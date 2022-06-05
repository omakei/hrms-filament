<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmployeeCompanyDetail>
 */
class EmployeeCompanyDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'employee_number' => 'OMA-'.rand(111,444).'-'.rand(555,999).'-'. now()->year,
            'joined_at' => now(),
            'left_at' => now()->addYears(3),
            'status' => now()->addYears(3),
            'department_id' => (Department::inRandomOrder()->first())->id,
            'employee_id' => Employee::factory(),
            'manager_id' => Employee::factory(),
            'shift_id' => (Shift::inRandomOrder()->first())->id,
        ];
    }
}
