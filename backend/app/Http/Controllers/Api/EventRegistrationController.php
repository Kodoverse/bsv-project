<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    // Middleware is now applied via routes or middleware attributes

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        \Log::info('EventRegistrationController@index called', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->user_role,
            'is_admin' => Auth::user()?->hasAdminPrivileges(),
            'request_params' => $request->all()
        ]);

        $registrations = EventRegistration::with(['event', 'user'])
            ->when($request->event_id, function ($query, $eventId) {
                return $query->where('event_id', $eventId);
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('registered_at', 'desc')
            ->paginate(20);

        \Log::info('Registrations found', [
            'count' => $registrations->count(),
            'total' => $registrations->total()
        ]);

        return response()->json($registrations);
    }

    /**
     * Register current user for an event
     */
    public function register(Event $event): JsonResponse
    {
        // Check if event is full
        if ($event->max_participants && $event->registrations()->count() >= $event->max_participants) {
            return response()->json(['message' => 'Event is full'], 422);
        }

        // Check if event is upcoming
        if ($event->status !== 'upcoming') {
            return response()->json(['message' => 'Can only register for upcoming events'], 422);
        }

        try {
            $existing = EventRegistration::where('event_id', $event->id)
                ->where('user_id', Auth::id())
                ->latest('created_at')
                ->first();

            if ($existing) {
                // Aggiorna stato e timestamp
                $existing->update([
                    'status' => 'registered',
                    'updated_at' => now(),
                ]);

                return response()->json($existing->load(['event', 'user']), 200);
            }

            // Nessuna registrazione precedente → nuova iscrizione
            $registration = EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'status' => 'registered',
            ]);

            return response()->json($registration->load(['event', 'user']), 201);
        } catch (\Exception $e) {
            \Log::error('Event registration error: ' . $e->getMessage());
            return response()->json(['message' => 'Registration failed. Please try again.'], 500);
        }
    }
    /**
     * Cancel registration
     */
    public function cancel(Event $event): JsonResponse
    {
        $registration = $event->registrations()
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'No registration found'], 404);
        }

        if ($registration->status === 'cancelled') {
            return response()->json(['message' => 'Already cancelled'], 422);
        }

        try {
            $registration->update([
                'status' => 'cancelled',
                'updated_at' => now(),
            ]);

            return response()->json(['message' => 'Registration cancelled successfully']);
        } catch (\Exception $e) {
            \Log::error('Event cancellation error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to cancel registration. Please try again.'], 500);
        }
    }

    /**
     * Update registration status (admin only)
     */
    public function updateStatus(EventRegistration $registration, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:registered,cancelled,attended,no_show',
            'notes' => 'nullable|string'
        ]);

        $registration->update($validated);

        return response()->json($registration->load(['event', 'user']));
    }

    /**
     * Get current user's registrations
     */
    public function myRegistrations(Request $request): JsonResponse
    {
        \Log::info('myRegistrations called', [
            'user_id' => Auth::id(),
            'user' => Auth::user(),
            'request_status' => $request->status
        ]);

        $registrations = EventRegistration::with(['event.category'])
            ->where('user_id', Auth::id())
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('registered_at', 'desc')
            ->paginate(10);

        \Log::info('Registrations found', [
            'count' => $registrations->count(),
            'total' => $registrations->total(),
            'registrations' => $registrations->toArray()
        ]);

        return response()->json($registrations);
    }
}
