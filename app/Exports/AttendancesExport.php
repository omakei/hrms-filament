<?php

namespace App\Exports;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendancesExport implements FromQuery, WithMapping
{


    public function map($row): array
    {

        return $row;
    }

    public function query(): Collection
    {
        $employees = Employee::with(['attendances' => function ($query){
            $query->whereBetween('recorded_at',[Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        }])->get();

        $index = 0;
        $data = [];
        foreach ($employees as $employee){

            $data[$index]['employee_name'] = $employee->full_name;
            for($i=1;$i<=Carbon::now()->daysInMonth; $i++) {
                $data[$index]['day'][$i] = $i;
                $data[$index]['attendance'][$i] = !empty($employee->attendances?->filter(
                    function ($item) use ($i) {
                        return false !== stripos((new Carbon($item->recorded_at))->toDateString(),
                                (new Carbon(Carbon::now()->year.'-'.Carbon::now()->month.'-'.$i))->toDateString());
                    })->first()) ?
                    ($employee->attendances?->filter(
                        function ($item) use ($i) {
                            return false !== stripos((new Carbon($item->recorded_at))->toDateString(),
                                    (new Carbon(Carbon::now()->year.'-'.Carbon::now()->month.'-'.$i))->toDateString());
                        })->first())?->status
                    : '';
            }
            $index++;
        }

        return collect($data);
    }
}
