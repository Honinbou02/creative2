<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@themetags.com')->first();

        if(empty($user)) {
            DB::table('users')->insert([
                'name'              => 'Admin',
                'is_active'         => 1,
                'user_type'         => 1,
                'email'             => 'admin@themetags.com',
                'email_verified_at' => date("Y-m-d H:i:s"),
                'password'          => bcrypt(1234567),
                'created_at'        => date("Y-m-d H:i:s"),
            ]);
        }
    }
}
