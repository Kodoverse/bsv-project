<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $business_categories = config('bsvdb.business_categories');
        foreach ($business_categories as $business_category) {
            $newBusinessCategory = new BusinessCategory();
            $newBusinessCategory->name = $business_category['name'];
            $newBusinessCategory->slug = $business_category['slug'];
            $newBusinessCategory->save();
        }
    }
}
