<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = config('bsvdb.sections');
        foreach ($sections as $section) {
            $newSection = new Section();
            $newSection->title = $section['title'];
            $newSection->save();
        }
    }
}
