<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Get admin dashboard statistics
     */
    public function dashboardStats(): JsonResponse
    {
        $stats = [
            'total_users' => User::count(),
            'total_events' => Event::count(),
            'upcoming_events' => Event::where('status', 'upcoming')->count(),
            'total_categories' => EventCategory::count(),
            'total_registrations' => EventRegistration::where('status', 'registered')->count(),
            'recent_registrations' => EventRegistration::with(['user.info', 'event'])
                ->where('status', 'registered')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
        ];

        return response()->json($stats);
    }


    /**
     * Get all users with their roles
     */
    public function users(Request $request): JsonResponse
    {
        $query = User::with('info');

        if ($request->has('role')) {
            $query->where('user_role', $request->role);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhereHas('info', function($infoQuery) use ($search) {
                      $infoQuery->where('firstname', 'like', "%{$search}%")
                               ->orWhere('lastname', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->orderBy('created_at', 'desc')
                      ->paginate(20);

        return response()->json($users);
    }

    /**
     * Update user role (admin only)
     */
    public function updateUserRole(User $user, Request $request): JsonResponse
    {
        $validated = $request->validate([
            'role' => 'required|in:user,admin,librarian,partner'
        ]);

        $user->update(['user_role' => $validated['role']]);

        return response()->json([
            'message' => 'User role updated successfully',
            'user' => $user->fresh(['info'])
        ]);
    }
}
