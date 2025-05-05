<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = config('bsvdb.users');
        foreach ($users as $user) {
            $newUser = new User();
            $newUser->email = $user['email'];
            $newUser->password = Hash::make($user['password']);
            $newUser->user_role = $user['user_role'];
            $newUser->save();
        }
    }
}
