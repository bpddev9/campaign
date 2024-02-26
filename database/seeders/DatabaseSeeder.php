<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Certification;
use App\Models\CompanyProfile;
use App\Models\Employment;
use App\Models\Publication;
use App\Models\Qualification;
use App\Models\Resume;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(
        //     UserSeeder::class,
        // );

        // \App\Models\User::factory(10)->create();

        // Resume::factory(10)->create();
        // CompanyProfile::factory(10)->create();

        // WorkExperience::factory(20)->create();
        // Publication::factory(30)->create();
        // Qualification::factory(30)->create();
        // Employment::factory(20)->create();
        // Certification::factory(10)->create();

        $this->call([
            UserSeeder::class,
            IndustrySeeder::class,
            JobTitleSeeder::class,
        ]);
    }
}
