<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PurchasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $purchases = config('bsvdb.purchases');
        foreach ($purchases as $purchase) {
            $newPurchase = new Purchase();
            $newPurchase->user_id = $purchase['user_id'];
            $newPurchase->product_id = $purchase['product_id'];
            $newPurchase->partner_id = $purchase['partner_id'];
            $newPurchase->quantity = $purchase['quantity'];
            $newPurchase->points_spent = $purchase['points_spent'];
            $newPurchase->points_per_item = $purchase['points_per_item'];
            $newPurchase->status = $purchase['status'];
            $newPurchase->redemption_code = $purchase['redemption_code'];
            $newPurchase->notes = $purchase['notes'];
            $newPurchase->confirmed_at = $purchase['confirmed_at'];
            $newPurchase->completed_at = $purchase['completed_at'];
            $newPurchase->created_at = $purchase['created_at'];
            $newPurchase->updated_at = $purchase['updated_at'];
            $newPurchase->save();
        }
    }
}
