<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventCategory;

class EventCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cinema',
                'description' => 'Movie screenings and film-related events',
                'color' => '#FF5733'
            ],
            [
                'name' => 'Gaming',
                'description' => 'Video games, board games, and gaming tournaments',
                'color' => '#33FF57'
            ],
            [
                'name' => 'Languages',
                'description' => 'Language learning and cultural exchange events',
                'color' => '#3357FF'
            ],
            [
                'name' => 'Workshops',
                'description' => 'Educational and skill-building workshops',
                'color' => '#FF33F5'
            ],
            [
                'name' => 'Book Club',
                'description' => 'Book discussions and reading groups',
                'color' => '#33FFF5'
            ],
            [
                'name' => 'Volunteering',
                'description' => 'Community service and volunteer opportunities',
                'color' => '#F5FF33'
            ]
        ];

        foreach ($categories as $category) {
            EventCategory::create($category);
        }
    }
}
