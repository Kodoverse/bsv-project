<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\User;
use Carbon\Carbon;

class EventRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('user_role', 'user')->take(10)->get();
        if ($users->isEmpty()) {
            $users = User::take(10)->get(); // Fallback to any users if no regular users
        }

        $events = Event::all();
        $statuses = ['registered', 'cancelled', 'attended', 'no_show'];

        // Register users for past events
        $pastEvents = Event::where('status', 'finished')->get();
        foreach ($pastEvents as $event) {
            // Register up to 3-8 users for each past event
            $registrationCount = min($users->count(), rand(3, 8));
            $eventUsers = $users->random($registrationCount);

            foreach ($eventUsers as $user) {
                EventRegistration::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'registered_at' => Carbon::parse($event->starts_at)->subDays(rand(1, 14)),
                    'status' => $statuses[array_rand(['attended', 'no_show'])]
                ]);
            }
        }

        // Register users for upcoming events
        $upcomingEvents = Event::where('status', 'upcoming')->get();
        foreach ($upcomingEvents as $event) {
            // Register up to 2-5 users for each upcoming event
            $registrationCount = min($users->count(), rand(2, 5));
            $eventUsers = $users->random($registrationCount);

            foreach ($eventUsers as $user) {
                EventRegistration::create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                    'registered_at' => Carbon::now()->subDays(rand(1, 7)),
                    'status' => array_rand(['registered' => true, 'cancelled' => true]) ? 'registered' : 'cancelled'
                ]);
            }
        }
    }
}
