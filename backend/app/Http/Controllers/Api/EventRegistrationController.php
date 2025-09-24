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
            ->when($request->event_id, function($query, $eventId) {
                return $query->where('event_id', $eventId);
            })
            ->when($request->status, function($query, $status) {
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
            return response()->json([
                'message' => 'Event is full'
            ], 422);
        }

        // Check if event is upcoming
        if ($event->status !== 'upcoming') {
            return response()->json([
                'message' => 'Can only register for upcoming events'
            ], 422);
        }

        try {
            $registration = EventRegistration::create([
                'event_id' => $event->id,
                'user_id' => Auth::id(),
                'status' => 'registered'
            ]);

            return response()->json($registration->load(['event', 'user']), 201);
        } catch (\Exception $e) {
            // Handle unique constraint violation (already registered)
            if (str_contains($e->getMessage(), 'Duplicate entry') || $e->getCode() === 23000) {
                return response()->json([
                    'message' => 'Already registered for this event'
                ], 422);
            }
            
            // Log the error for debugging
            \Log::error('Event registration error: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Cancel registration
     */
    public function cancel(Event $event): JsonResponse
    {
        $registration = $event->registrations()
            ->where('user_id', Auth::id())
            ->where('status', 'registered') // Only allow cancelling active registrations
            ->first();

        if (!$registration) {
            return response()->json([
                'message' => 'Not registered for this event or registration already cancelled'
            ], 404);
        }

        try {
            // Delete the registration record to allow re-registration
            $registration->delete();

            return response()->json([
                'message' => 'Registration cancelled successfully'
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Event cancellation error: ' . $e->getMessage());
            
            return response()->json([
                'message' => 'Failed to cancel registration. Please try again.'
            ], 500);
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
            ->when($request->status, function($query, $status) {
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
