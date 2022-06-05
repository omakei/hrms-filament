<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\PayScale;
use App\Models\SalaryType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeFinancialDetails>
 */
class EmployeeFinancialDetailsFactory extends Factory
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
            'salary_type_id' => (SalaryType::inRandomOrder()->frist())->id,
            'pay_scale_id' => (PayScale::inRandomOrder()->frist())->id,
        ];
    }
}
