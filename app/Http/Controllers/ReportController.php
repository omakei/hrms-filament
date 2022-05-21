<?php

namespace App\Http\Controllers;


use App\Models\Employee;
use App\Models\PayRoll;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReportController extends Controller
{
    public  function payslip(PayRoll $payroll)
    {

        $pdf = PDF::loadView('templates.payslip',
            ['data' => $payroll, 'qrcode' => QrCode::size(400)->color(0,0,0)->generate($payroll)])
            ->setPaper('a4','landscape');

        return $pdf->stream('payslip-'.$payroll->employee->full_name.now()->unix().'.pdf');
    }

    public  function performance()
    {
        $employees = Employee::with(['performances' => function ($query){
            $query->whereBetween('created_at',[Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
        }])->get();

        $index = 0;
        $data = [];
        foreach ($employees as $employee){

            $data[$index]['employee_name'] = $employee->full_name;
            for($i=1;$i<=Carbon::now()->daysInMonth; $i++) {
                $data[$index]['day'][$i] = $i;
                $data[$index]['performance'][$i] = !empty($employee->performances?->filter(
                    function ($item) use ($i) {
                        return false !== stripos((new Carbon($item->created_at))->toDateString(),
                                (new Carbon(Carbon::now()->year.'-'.Carbon::now()->month.'-'.$i))->toDateString());
                    })->first()) ?
                    ($employee->performances?->filter(
                        function ($item) use ($i) {
                            return false !== stripos((new Carbon($item->created_at))->toDateString(),
                                    (new Carbon(Carbon::now()->year.'-'.Carbon::now()->month.'-'.$i))->toDateString());
                        })->first())?->ratings
                    : '';
            }
            $index++;
        }

        $pdf = PDF::loadView('templates.performance',
            ['data' => collect($data), 'qrcode' => QrCode::size(400)->color(0,0,0)->generate('omakei and lil buu on this one')])
            ->setPaper('a4','landscape');

        return $pdf->stream('performance-'.now()->unix().'.pdf');
    }

    public  function attendance()
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

        $pdf = PDF::loadView('templates.attendance',
            ['data' => collect($data), 'qrcode' => QrCode::size(400)->color(0,0,0)->generate('omakei and lil buu on this one')])
            ->setPaper('a4','landscape');

        return $pdf->stream('attendance-'.now()->unix().'.pdf');
    }
}
