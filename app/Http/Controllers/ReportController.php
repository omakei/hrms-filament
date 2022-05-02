<?php

namespace App\Http\Controllers;


use App\Models\PayRoll;
use Barryvdh\DomPDF\Facade\Pdf;
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

//    public  function referral(PatientReferral $referral)
//    {
//
//        $pdf = PDF::loadView('templates.referral',
//            ['data' => $referral, 'qrcode' => QrCode::size(400)->color(0,0,0)->generate($referral)])
//            ->setPaper('a4','portrait');
//
//        return $pdf->stream('referral-'.$referral->visit->visit_number.now()->unix().'.pdf');
//    }
//
//    public  function prescription(PatientPrescription $prescription)
//    {
//
//        $pdf = PDF::loadView('templates.prescription',
//            ['data' => $prescription, 'qrcode' => QrCode::size(400)->color(0,0,0)->generate($prescription)])
//            ->setPaper('a4','landscape');
//
//        return $pdf->stream('prescription-'.$prescription->visit->visit_number.now()->unix().'.pdf');
//    }
}
