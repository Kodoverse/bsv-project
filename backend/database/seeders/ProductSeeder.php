<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = config("bsvdb.products");
        foreach ($products as $product) {
            $newProduct = new Product();
            $newProduct->partner_id = $product['partner_id'];
            $newProduct->category_id = $product['category_id'];
            $newProduct->name = $product['name'];
            $newProduct->description = $product['description'];
            $newProduct->image_url = $product['image_url'];
            $newProduct->points_price = $product['points_price'];
            $newProduct->cash_equivalent = $product['cash_equivalent'];
            $newProduct->stock_quantity = $product['stock_quantity'];
            $newProduct->is_available = $product['is_available'];
            $newProduct->metadata = $product['metadata'];
            $newProduct->created_at = $product['created_at'];
            $newProduct->updated_at = $product['updated_at'];
            $newProduct->save();
        }
    }
}
