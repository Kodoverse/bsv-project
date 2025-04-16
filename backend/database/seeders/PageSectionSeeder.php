<?php

namespace Database\Seeders;

use App\Models\PageSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageSections = config('bsvdb.page_sections');
        foreach ($pageSections as $pageSection) {
            $newPageSection = new PageSection();
            $newPageSection->type = $pageSection['type'];
            $newPageSection->content = $pageSection['content'];
            $newPageSection->section_id = $pageSection['section_id'];
            $newPageSection->save();
        }
    }
}
