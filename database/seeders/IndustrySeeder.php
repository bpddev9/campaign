<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('industries')->insert([
            [
                'title' => 'Fundraising',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Digital',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Communications',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Field',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'General Consulting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
