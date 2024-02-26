<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
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
            'certificate' => fake()->text(20),
            'award_org' => fake()->text(20),
            'summary' => fake()->paragraph(3),
            'start_year' => fake()->numberBetween(1990, 2023),
            'type' => fake()->randomElement(['certification', 'award'])
        ];
    }
}
