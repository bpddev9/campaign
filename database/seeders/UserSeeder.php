<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Suman Roy',
            'email' => 'bpddev9@gmail.com',
            'password' => Hash::make('password'),
            'phone_no' => '7866666',
            'role' => 'campaign',
            'political_group' => 'nonpartisan',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Deep Karmakar',
            'email' => 'bpddev2@gmail.com',
            'phone_no' => '787667766',
            'password' => Hash::make('password'),
            'role' => 'campaign',
            'political_group' => 'nonpartisan',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Sk Islam',
            'email' => 'bpdreact3@gmail.com',
            'phone_no' => '7876688666',
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'political_group' => 'nonpartisan',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('users')->insert([
            'name' => 'Susmita Bhoumik',
            'email' => 'bpddev8@gmail.com',
            'phone_no' => '787665666',
            'password' => Hash::make('password'),
            'role' => 'applicant',
            'political_group' => 'nonpartisan',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
