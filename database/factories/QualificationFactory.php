<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qualification>
 */
class QualificationFactory extends Factory
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
            'institute_name' => fake()->text(50),
            'degree' => fake()->text(50),
            'start_year' => fake()->year(),
            'end_year' => date('Y')
        ];
    }
}
