<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->lastName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
            'dob' => now()->subYears(20),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'phone_1' => $this->faker->e164PhoneNumber,
            'phone_2' => $this->faker->e164PhoneNumber,
            'current_address' => $this->faker->address,
            'permanent_address' => $this->faker->address,
            'nationality' => 'Tanzanian',
            'reference_name_1' => $this->faker->lastName,
            'reference_phone_1' => $this->faker->e164PhoneNumber,
            'reference_name_2' => $this->faker->lastName,
            'reference_phone_2' => $this->faker->e164PhoneNumber,
            'marital_status' => $this->faker->randomElement(['Married', 'Single']),
            'comment' => $this->faker->text,
        ];
    }
}
