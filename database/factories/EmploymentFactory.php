<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employment>
 */
class EmploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // $employrs = User::where('role', 'campaign')->pluck('id')->toArray();
        $employrs = User::where('role', 'campaign')->pluck('id')->random();
        $payRates = ['hourly', 'daily', 'weekly', 'monthly', 'yearly'];
        $jobTypes = ['Full time', 'Fresher', 'Part time', 'internship'];

        return [
            'user_id' => $employrs,
            'job_title' => fake()->sentence(rand(3,6)),
            'job_position' => fake()->jobTitle(),
            'job_type' => $jobTypes[rand(0,3)],
            'location_type' => fake()->randomElement(['remote', 'office']),
            'can_call' => fake()->randomElement([1, 0]),
            'can_post_resume' => fake()->randomElement([1, 0]),
            'job_description' => fake()->text(250),
            'no_of_people' => fake()->numberBetween(5, 10),
            'max_salary' => fake()->numberBetween(6000, 7000),
            'job_schedule' => '9-to-5',
            'pay_rate' => $payRates[rand(0,4)],
            'min_salary' => fake()->randomNumber(rand(3,4), false),
        ];
    }
}
