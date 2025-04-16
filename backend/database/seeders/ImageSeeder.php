<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = config('bsvdb.images');
        foreach ($images as $image) {
            $newImage = new Image();
            $newImage->name = $image['name'];
            $newImage->alt = $image['alt'];
            $newImage->link = $image['link'];
            $newImage->article_id = $image['article_id'];
            $newImage->page_section_id = $image['page_section_id'];
            $newImage->save();
        }
    }
}
