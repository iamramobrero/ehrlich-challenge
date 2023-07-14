<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // just random identifier for user name and email
        $userIdentifier = uniqid();

        DB::table('users')->insert([
            'name' => 'User '.$userIdentifier,
            'email' => $userIdentifier.'@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
