<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\PayScale;
use App\Models\SalaryType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeBankAccountDetail>
 */
class EmployeeBankAccountDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_id' => Employee::factory(),
            'account_holder_name' => $this->faker->name,
            'account_number' => $this->faker->name,
            'bank_name' => $this->faker->company,
            'branch' => $this->faker->city,
            'bank_code' => Str::random(5),
        ];
    }
}
