<?php

namespace Database\Seeders;
use App\Models\Tag;   
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = config('bsvdb.tags');
        foreach ($tags as $tag) {
            $newTag = new Tag();
            $newTag->name = $tag['name'];
            $newTag->save();
        }
    }
}
