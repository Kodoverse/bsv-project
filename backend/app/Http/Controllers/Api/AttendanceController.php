<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Confirm attendance for a user at an event
     */
    public function confirmAttendance(Request $request, Event $event): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'attended' => 'required|boolean',
            'notes' => 'nullable|string'
        ]);

        // Check if event is a volunteer event
        if (!$event->is_volunteer_event) {
            return response()->json([
                'message' => 'Attendance can only be confirmed for volunteer events'
            ], 422);
        }

        // Find the registration
        $registration = EventRegistration::where('event_id', $event->id)
            ->where('user_id', $validated['user_id'])
            ->where('status', 'registered')
            ->first();

        if (!$registration) {
            return response()->json([
                'message' => 'User is not registered for this event'
            ], 404);
        }

        // Update registration status
        $newStatus = $validated['attended'] ? 'attended' : 'no_show';
        $registration->update([
            'status' => $newStatus,
            'notes' => $validated['notes'] ?? null
        ]);

        // Award points if attended and event has points
        if ($validated['attended'] && $event->volunteer_points > 0) {
            // Check if points already awarded
            $existingPoints = Point::where('user_id', $validated['user_id'])
                ->where('event_id', $event->id)
                ->where('type', 'award')
                ->first();

            if (!$existingPoints) {
                Point::create([
                    'user_id' => $validated['user_id'],
                    'event_id' => $event->id,
                    'awarded_by' => Auth::id(),
                    'points' => $event->volunteer_points,
                    'reason' => "Attended volunteer event: {$event->title}",
                    'type' => 'award'
                ]);
            }
        }

        // Remove points if marked as no-show (in case they were previously marked as attended)
        if (!$validated['attended']) {
            Point::where('user_id', $validated['user_id'])
                ->where('event_id', $event->id)
                ->where('type', 'award')
                ->delete();
        }

        return response()->json([
            'message' => 'Attendance updated successfully',
            'registration' => $registration->fresh(['user.info'])
        ]);
    }

    /**
     * Get event registrations with attendance status
     */
    public function getEventAttendance(Event $event): JsonResponse
    {
        // Check if event is a volunteer event
        if (!$event->is_volunteer_event) {
            return response()->json([
                'message' => 'Attendance tracking is only available for volunteer events'
            ], 422);
        }

        $registrations = EventRegistration::with(['user.info'])
            ->where('event_id', $event->id)
            ->whereIn('status', ['registered', 'attended', 'no_show'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Add points information for each registration
        $registrations->each(function ($registration) use ($event) {
            $hasPoints = Point::where('user_id', $registration->user_id)
                ->where('event_id', $event->id)
                ->where('type', 'award')
                ->exists();
            
            $registration->points_awarded = $hasPoints;
            $registration->potential_points = $event->volunteer_points;
        });

        return response()->json([
            'event' => $event,
            'registrations' => $registrations,
            'summary' => [
                'total_registered' => $registrations->count(),
                'attended' => $registrations->where('status', 'attended')->count(),
                'no_show' => $registrations->where('status', 'no_show')->count(),
                'pending' => $registrations->where('status', 'registered')->count(),
            ]
        ]);
    }

    /**
     * Bulk update attendance for multiple users
     */
    public function bulkUpdateAttendance(Request $request, Event $event): JsonResponse
    {
        $validated = $request->validate([
            'attendances' => 'required|array',
            'attendances.*.user_id' => 'required|exists:users,id',
            'attendances.*.attended' => 'required|boolean',
            'attendances.*.notes' => 'nullable|string'
        ]);

        if (!$event->is_volunteer_event) {
            return response()->json([
                'message' => 'Attendance can only be confirmed for volunteer events'
            ], 422);
        }

        $results = [];
        
        foreach ($validated['attendances'] as $attendance) {
            $request = new Request();
            $request->merge($attendance);
            
            $result = $this->confirmAttendance($request, $event);
            $results[] = [
                'user_id' => $attendance['user_id'],
                'success' => $result->getStatusCode() === 200,
                'message' => $result->getData()->message ?? null
            ];
        }

        return response()->json([
            'message' => 'Bulk attendance update completed',
            'results' => $results
        ]);
    }
}