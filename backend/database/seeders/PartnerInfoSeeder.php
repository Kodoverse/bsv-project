<?php

namespace Database\Seeders;

use App\Models\PartnerInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partner_infos = config('bsvdb.partner_infos');
        foreach ($partner_infos as $partner_info) {
            $newPartnerInfo = new PartnerInfo();
            $newPartnerInfo->user_id = $partner_info['user_id'];
            $newPartnerInfo->name = $partner_info['name'];
            $newPartnerInfo->lastname = $partner_info['lastname'];
            $newPartnerInfo->birthday = $partner_info['birthday'];
            $newPartnerInfo->contact_phone = $partner_info['contact_phone'];
            $newPartnerInfo->redemption_rules = $partner_info['redemption_rules'];
            $newPartnerInfo->min_points_per_redemption = $partner_info['min_points_per_redemption'];
            $newPartnerInfo->max_points_per_redemption = $partner_info['max_points_per_redemption'];
            $newPartnerInfo->is_active = $partner_info['is_active'];
            $newPartnerInfo->save();
        }
    }
}
