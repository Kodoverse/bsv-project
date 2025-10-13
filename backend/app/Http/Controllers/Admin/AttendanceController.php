<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $events = Event::withCount([
            'registrations as total_registered' => function ($q) {
                $q->whereIn('status', ['registered', 'attended', 'no_show']);
            }
        ])
            ->orderBy('starts_at', 'desc')
            ->get();

        $events->each(function ($event) {
            $event->attended_count = $event->registrations()->where('status', 'attended')->count();
            $event->no_show_count = $event->registrations()->where('status', 'no_show')->count();
        });
        dd($events);
        return view("admin.attendances.index", compact("events"));
    }
}
