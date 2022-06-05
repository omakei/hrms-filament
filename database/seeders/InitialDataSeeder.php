<?php

namespace Database\Seeders;

use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\LeaveType;
use App\Models\PayScale;
use App\Models\SalaryType;
use App\Models\Shift;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $department_data = [
            ['find' =>  ['name' => 'Sales'], 'fields' => [ 'description' => 'Sales']],
            ['find' =>  ['name' => 'Grocery'], 'fields' => [ 'description' => 'Grocery']],
            ['find' =>  ['name' => 'Frozen Food'], 'fields' => [ 'description' => 'Frozen Food']],
            ['find' =>  ['name' => 'Front End'], 'fields' => [ 'description' => 'Front End']],
            ['find' =>  ['name' => 'HR'], 'fields' => [ 'description' => 'HR']],
            ['find' =>  ['name' => 'IT'], 'fields' => [ 'description' => 'IT']],
            ['find' =>  ['name' => 'Accounting and Finance'], 'fields' => [ 'description' => 'Accounting and Finance']],
        ];

        $designations = [
            ['name' => 'Manager'],
            ['name' => 'Assistant Manager'],
            ['name' => 'Staff'],
        ];

        foreach($department_data as $data) {
            $department = Department::firstOrCreate($data['find'],$data['fields']);
            $department->designations()->saveMany($designations);
        }

        $allowances = [
            ['name' => 'Transportation'],
            ['name' => 'Airtime'],
            ['name' => 'Internet'],
            ['name' => 'Meal Allowance'],
            ['name' => 'Housing Allowance'],
        ];

        $deductions = [
            ['name' => 'NSSF'],
            ['name' => 'NHIF'],
            ['name' => 'TAX'],
            ['name' => 'LOAN'],
            ['name' => 'HESLB'],
        ];

        foreach($allowances as $data) {
            Allowance::create($data);
        }

        foreach($deductions as $data) {
            Deduction::create($data);
        }

        $pay_scales = [
            ['name' => 'Manager', 'basic_salary' => 700000, 'description' => 'Manager'],
            ['name' => 'Assistance Manager', 'basic_salary' => 500000, 'description' => 'Assistance Manager'],
            ['name' => 'Staff', 'basic_salary' => 300000, 'description' => 'Staff'],
        ];

        foreach($pay_scales as $data) {
            PayScale::create($data);
        }

        foreach(PayScale::all() as $data) {
            $data->allowances()->sync((Allowance::firstWhere('name' , 'Transportation'))->id, ['amount' => rand(10000,90000)]);
            $data->allowances()->sync((Allowance::firstWhere('name' , 'Airtime'))->id, ['amount' => rand(10000,90000)]);
            $data->allowances()->sync((Allowance::firstWhere('name' , 'Internet'))->id, ['amount' => rand(10000,90000)]);
            $data->allowances()->sync((Allowance::firstWhere('name' , 'Meal Allowance'))->id, ['amount' => rand(10000,90000)]);
            $data->allowances()->sync((Allowance::firstWhere('name' , 'Housing Allowance'))->id, ['amount' => rand(10000,90000)]);

            $data->deductions()->sync((Deduction::firstWhere('name' , 'NSSF'))->id, ['amount' => rand(10000,90000)]);
            $data->deductions()->sync((Deduction::firstWhere('name' , 'NHIF'))->id, ['amount' => rand(10000,90000)]);
            $data->deductions()->sync((Deduction::firstWhere('name' , 'TAX'))->id, ['amount' => rand(10000,90000)]);
            $data->deductions()->sync((Deduction::firstWhere('name' , 'LOAN'))->id, ['amount' => rand(10000,90000)]);
            $data->deductions()->sync((Deduction::firstWhere('name' , 'HESLB'))->id, ['amount' => rand(10000,90000)]);
        }

        $leave_types = [
            ['name' => 'Sick Leave', 'credit_type' => 1, 'credit_leaves' => 'Week', 'description' => 'Sick Leave'],
            ['name' => 'Annual Leave', 'credit_type' => 28, 'credit_leaves' => 'Days', 'description' => 'Annual Leave'],
            ['name' => 'Maternity Leave', 'credit_type' => 28, 'credit_leaves' => 'Days', 'description' => 'Maternity Leave'],
            ['name' => 'Leave Pending Completion of Contract', 'credit_type' => 6, 'credit_leaves' => 'Days', 'description' => 'Leave Pending Completion of Contract'],
            ['name' => 'Leave Pending retirement', 'credit_type' => 10, 'credit_leaves' => 'Days', 'description' => 'Leave Pending retirement'],
            ['name' => 'Paternity Leave', 'credit_type' => 3, 'credit_leaves' => 'Days', 'description' => 'Paternity Leave'],
            ['name' => 'Special Leave of Absence', 'credit_type' => 1, 'credit_leaves' => 'Days', 'description' => 'Special Leave of Absence'],
            ['name' => 'Leave Without Pay', 'credit_type' => 5, 'credit_leaves' => 'Days', 'description' => 'Leave Without Pay'],
            ['name' => 'Sabbatical Leave', 'credit_type' => 1, 'credit_leaves' => 'Days', 'description' => 'Sabbatical Leave'],
            ['name' => 'Convalescent Leave', 'credit_type' => 5, 'credit_leaves' => 'Days', 'description' => 'Convalescent Leave'],
        ];

        foreach($leave_types as $data ) {
            LeaveType::create($data);
        }

        $salary_types = [
            ['name' => 'Manager', 'description' => 'Manager'],
            ['name' => 'Assistance Manager','description' => 'Assistance Manager'],
            ['name' => 'Staff', 'description' => 'Staff'],
        ];

        foreach($salary_types as $data) {
            SalaryType::create($data);
        }

        $shifts = [
            ['name' => 'Morning Shift', 'start' => '08:00', 'end' => '16:00','days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']],
            ['name' => 'Night Shift', 'start' => '18:00', 'end' => '07:00','days' => ['monday', 'tuesday', 'wednesday', 'thursday', 'friday']]
        ];

        foreach($shifts as $data) {
            Shift::create($data);
        }

    }
}
