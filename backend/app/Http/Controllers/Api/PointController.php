<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Point;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    // Note: Middleware is now handled in routes/api.php instead of constructor
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $points = Point::with(['user', 'event', 'awardedBy'])
            ->when($request->event_id, function($query, $eventId) {
                return $query->where('event_id', $eventId);
            })
            ->when($request->user_id, function($query, $userId) {
                return $query->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($points);
    }

    /**
     * Award points to a user for an event
     */
    public function awardPoints(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:events,id',
            'points' => 'required|integer',
            'reason' => 'required|string'
        ]);

        // Check if event is volunteer event
        $event = Event::findOrFail($validated['event_id']);
        if (!$event->is_volunteer_event) {
            return response()->json([
                'message' => 'Points can only be awarded for volunteer events'
            ], 422);
        }

        $validated['awarded_by'] = Auth::id();

        $points = Point::create($validated);

        return response()->json($points->load(['user', 'event', 'awardedBy']), 201);
    }

    /**
     * Get points for current user
     */
    public function myPoints(): JsonResponse
    {
        $points = Point::with(['event', 'awardedBy'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate total points
        $totalPoints = Point::where('user_id', Auth::id())
            ->sum('points');

        return response()->json([
            'points' => $points,
            'total_points' => $totalPoints
        ]);
    }

    /**
     * Get user points summary
     */
    public function userSummary(User $user): JsonResponse
    {
        $points = Point::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $totalPoints = Point::where('user_id', $user->id)
            ->sum('points');

        $eventCount = Point::where('user_id', $user->id)
            ->distinct('event_id')
            ->count('event_id');

        return response()->json([
            'user' => $user,
            'recent_points' => $points,
            'total_points' => $totalPoints,
            'event_count' => $eventCount
        ]);
    }

    /**
     * Redeem points from a user
     */
    public function redeemPoints(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'points' => 'required|integer|min:1',
            'reason' => 'required|string',
            'redemption_reference' => 'required|string'
        ]);

        // Get the partner info
        $partner = Auth::user();
        if (!$partner->isPartner() || !$partner->partnerInfo->is_active) {
            return response()->json([
                'message' => 'Only active partners can redeem points'
            ], 403);
        }

        // Check partner's redemption rules
        $minPoints = $partner->partnerInfo->min_points_per_redemption;
        $maxPoints = $partner->partnerInfo->max_points_per_redemption;

        if ($validated['points'] < $minPoints) {
            return response()->json([
                'message' => "Minimum points for redemption is {$minPoints}"
            ], 422);
        }

        if ($maxPoints && $validated['points'] > $maxPoints) {
            return response()->json([
                'message' => "Maximum points for redemption is {$maxPoints}"
            ], 422);
        }

        // Check user's point balance
        $userBalance = Point::where('user_id', $validated['user_id'])->sum('points');
        if ($userBalance < $validated['points']) {
            return response()->json([
                'message' => 'Insufficient points balance'
            ], 422);
        }

        // Create redemption transaction (negative points)
        $redemption = Point::create([
            'user_id' => $validated['user_id'],
            'points' => -$validated['points'], // Negative for redemptions
            'reason' => $validated['reason'],
            'type' => 'redemption',
            'partner_id' => $partner->id,
            'redemption_reference' => $validated['redemption_reference'],
            'awarded_by' => $partner->id
        ]);

        return response()->json($redemption->load(['user', 'partner']), 201);
    }
}
