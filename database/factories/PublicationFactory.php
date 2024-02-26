<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Publication>
 */
class PublicationFactory extends Factory
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
            'publisher' => fake()->text(40),
            'summary' => fake()->text(300)
        ];
    }
}
