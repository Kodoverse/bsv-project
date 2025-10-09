<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('database/seeders/product_categories.json');
        $Categories = json_decode(file_get_contents($path), true);
        foreach ($Categories as $Category) {
            $newCategory = new ProductCategory();
            $newCategory->name = $Category['name'];
            $newCategory->slug = ProductCategory::generateSlug($Category['name']);
            $newCategory->save();
        }
    }
}
