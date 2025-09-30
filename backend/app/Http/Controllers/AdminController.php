<?php

namespace App\Http\Controllers;

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
    public function dashboardStats(Request $request)
    {
        $user = Auth::user();
        $tabs = [
            ['id' => 'overview', 'name' => 'Overview', 'url' => route('admin.dashboard', ['tab' => 'overview']), 'icon' => '<i class="icon-overview"></i>'],
            ['id' => 'events', 'name' => 'Events', 'url' => route('admin.dashboard', ['tab' => 'events']), 'icon' => '<i class="icon-events"></i>'],
            ['id' => 'attendance', 'name' => 'Attendance', 'url' => route('admin.dashboard', ['tab' => 'attendance']), 'icon' => '<i class="icon-attendance"></i>'],
            ['id' => 'categories', 'name' => 'Categories', 'url' => route('admin.dashboard', ['tab' => 'categories']), 'icon' => '<i class="icon-categories"></i>'],
            ['id' => 'users', 'name' => 'Users', 'url' => route('admin.dashboard', ['tab' => 'users']), 'icon' => '<i class="icon-users"></i>'],
            ['id' => 'registrations', 'name' => 'Registrations', 'url' => route('admin.dashboard', ['tab' => 'registrations']), 'icon' => '<i class="icon-registrations"></i>'],
            ['id' => 'partners', 'name' => 'Partners', 'url' => route('admin.dashboard', ['tab' => 'partners']), 'icon' => '<i class="icon-partners"></i>'],
        ];

        $activeTab = $request->query('tab', 'overview');

        // Stats esempio
        $stats = [
            ['title' => 'Total Users', 'value' => User::count(), 'bgColor' => 'bg-orange-500', 'icon' => '<i class="icon-users"></i>'],
            ['title' => 'Total Events', 'value' => Event::count(), 'bgColor' => 'bg-red-500', 'icon' => '<i class="icon-events"></i>'],
            ['title' => 'Upcoming Events', 'value' => Event::where('status', 'upcoming')->count(), 'bgColor' => 'bg-green-500', 'icon' => '<i class="icon-upcoming"></i>'],
            ['title' => 'Recent Registrations', 'value' => EventRegistration::where('status', 'registered')->count(), 'bgColor' => 'bg-blue-500', 'icon' => '<i class="icon-categories"></i>'],
        ];

        // Recent registrations
        $dashboardData = [
            'recent_registrations' => EventRegistration::with(['user.info', 'event'])
                ->where('status', 'registered')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get()
                ->toArray()
        ];

        $userRole = $user->user_role;

        // Classe colore per il ruolo (opzionale)
        $roleColorClass = $userRole === 'admin' ? 'text-orange-400' : 'text-blue-400';

        return view('admin.dashboard', compact(
            'user',
            'tabs',
            'activeTab',
            'stats',
            'dashboardData',
            'userRole',
            'roleColorClass'
        ));
    }
}
