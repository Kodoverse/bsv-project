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
        $categories = config('bsvdb.product_categories');
        foreach ($categories as $category) {
            $newCategory = new ProductCategory();
            $newCategory->name = $category['name'];
            $newCategory->slug = ProductCategory::generateSlug($category['name']);
            $newCategory->save();
        }
    }
}
