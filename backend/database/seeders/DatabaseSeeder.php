<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
/*
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        */
        $this->call([
            UserSeeder::class,
            ArticleSeeder::class,
            CommentSeeder::class,
            SectionSeeder::class,
            PageSectionSeeder::class,
            ImageSeeder::class,
            TagSeeder::class,
            ArticleTagSeeder::class,
            FlaggedCommentSeeder::class,
            EventCategorySeeder::class,
            EventSeeder::class,
            EventRegistrationSeeder::class,
            PointSeeder::class,
        ]);
    }
}
