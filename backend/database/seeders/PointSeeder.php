<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Point;
use App\Models\User;
use App\Models\EventRegistration;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get volunteer admins
        $admins = User::whereIn('user_role', ['admin', 'volunteer_admin'])->take(3)->get();
        if ($admins->isEmpty()) {
            $admins = [User::first()]; // Fallback to first user if no admins
        }

        // Get past volunteer events
        $volunteerEvents = Event::where('is_volunteer_event', true)
            ->where('status', 'finished')
            ->get();

        foreach ($volunteerEvents as $event) {
            // Get attendees of the event
            $attendees = EventRegistration::where('event_id', $event->id)
                ->where('status', 'attended')
                ->get();

            foreach ($attendees as $registration) {
                // Award random points between 5 and 15
                Point::create([
                    'user_id' => $registration->user_id,
                    'event_id' => $event->id,
                    'awarded_by' => $admins->random()->id,
                    'points' => rand(5, 15),
                    'reason' => 'Volunteering at ' . $event->title
                ]);
            }

            // Get no-shows and deduct points
            $noShows = EventRegistration::where('event_id', $event->id)
                ->where('status', 'no_show')
                ->get();

            foreach ($noShows as $registration) {
                // Deduct points for no-show
                Point::create([
                    'user_id' => $registration->user_id,
                    'event_id' => $event->id,
                    'awarded_by' => $admins->random()->id,
                    'points' => -5,
                    'reason' => 'No-show at ' . $event->title
                ]);
            }
        }
    }
}
