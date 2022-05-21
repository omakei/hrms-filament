<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('download-payslip/{payroll}', [ReportController::class, 'payslip'])
    ->name('payslip.download');
Route::get('download-performance', [ReportController::class, 'performance'])
    ->name('performance.download');
Route::get('download-attendance', [ReportController::class, 'attendance'])
    ->name('attendance.download');
