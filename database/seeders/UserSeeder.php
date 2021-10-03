<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        DB::table('users')->insert([[
            'name' => "User-E",
            'role_id' => 1,
            'email' => 'employee@test.com',
            'password' => Hash::make(12345678),
        ],[
            'name' => "User-M",
            'role_id' => 2,
            'email' => 'manager@test.com',
            'password' => Hash::make(12345678),
        ],[
            'name' => "User-HR-M",
            'role_id' => 3,
            'email' => 'hrmanager@test.com',
            'password' => Hash::make(12345678),
        ]]);
    }
}
