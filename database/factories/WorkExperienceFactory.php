<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkExperience>
 */
class WorkExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $applicants = User::where('role', 'applicant')->pluck('id')->random();
        return [
            'user_id' => $applicants,
            'title' => fake()->text(30),
            'company_name' => fake()->text(20),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now(),
            'description' => fake()->paragraph(4),
            'currently_working' => fake()->numberBetween(0,1),
        ];
    }
}
