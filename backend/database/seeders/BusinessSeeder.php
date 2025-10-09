<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $businesses = config('bsvdb.businesses');
        foreach ($businesses as $business) {
            $newBusiness = new Business();
            $newBusiness->name = $business['name'];
            $newBusiness->business_category_id = $business['business_category_id'];
            $newBusiness->partner_info_id = $business['partner_info_id'];
            $newBusiness->description = $business['description'];
            $newBusiness->logo = $business['logo'];
            $newBusiness->address = $business['address'];
            $newBusiness->hours = $business['hours'];
            $newBusiness->email = $business['email'];
            $newBusiness->website = $business['website'];
            $newBusiness->save();
        }
    }
}
