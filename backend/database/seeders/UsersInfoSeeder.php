<?php

namespace Database\Seeders;

use App\Models\UsersInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users_infos = config('bsvdb.users_infos');
        foreach ($users_infos as $user_info) {
            $newUserInfo = new UsersInfo();
            $newUserInfo->firstname = $user_info['firstname'];
            $newUserInfo->lastname = $user_info['lastname'];
            $newUserInfo->username = $user_info['username'];
            $newUserInfo->show_username = $user_info['show_username'];
            $newUserInfo->birthday = $user_info['birthday'];
            $newUserInfo->profile_img = $user_info['profile_img'];
            $newUserInfo->user_id = $user_info['user_id'];
            $newUserInfo->save();
        }
    }
}
