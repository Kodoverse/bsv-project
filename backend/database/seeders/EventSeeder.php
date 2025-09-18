<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\User;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some librarians to create events
        $librarians = User::where('user_role', 'librarian')->take(3)->get();
        if ($librarians->isEmpty()) {
            $librarians = collect([User::first()]); // Fallback to first user if no librarians
        }

        $categories = EventCategory::all();
        
        // Create some past events
        for ($i = 0; $i < 10; $i++) {
            $startDate = Carbon::now()->subDays(rand(30, 60));
            $endDate = (clone $startDate)->addHours(rand(1, 4));
            
            Event::create([
                'category_id' => $categories->random()->id,
                'created_by' => $librarians->random()->id,
                'title' => 'Past Event ' . ($i + 1),
                'description' => 'This is a past event description.',
                'starts_at' => $startDate,
                'ends_at' => $endDate,
                'status' => 'finished',
                'is_volunteer_event' => rand(0, 1) === 1,
                'max_participants' => rand(10, 50)
            ]);
        }

        // Create some upcoming events
        for ($i = 0; $i < 5; $i++) {
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addHours(rand(1, 4));
            
            Event::create([
                'category_id' => $categories->random()->id,
                'created_by' => $librarians->random()->id,
                'title' => 'Upcoming Event ' . ($i + 1),
                'description' => 'This is an upcoming event description.',
                'starts_at' => $startDate,
                'ends_at' => $endDate,
                'status' => 'upcoming',
                'is_volunteer_event' => rand(0, 1) === 1,
                'max_participants' => rand(10, 50)
            ]);
        }

        // Create some cancelled events
        for ($i = 0; $i < 2; $i++) {
            $startDate = Carbon::now()->addDays(rand(1, 30));
            $endDate = (clone $startDate)->addHours(rand(1, 4));
            
            Event::create([
                'category_id' => $categories->random()->id,
                'created_by' => $librarians->random()->id,
                'title' => 'Cancelled Event ' . ($i + 1),
                'description' => 'This event has been cancelled.',
                'starts_at' => $startDate,
                'ends_at' => $endDate,
                'status' => 'cancelled',
                'is_volunteer_event' => rand(0, 1) === 1,
                'max_participants' => rand(10, 50)
            ]);
        }
    }
}
