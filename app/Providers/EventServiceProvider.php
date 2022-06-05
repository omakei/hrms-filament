<?php

namespace App\Providers;

use App\Models\Deduction;
use App\Models\PayRoll;
use App\Models\PayScale;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        PayScale::created(function(PayScale $payScale){
            $this->calculateDeductions($payScale);
        });

        PayScale::updated(function(PayScale $payScale){
             $this->calculateDeductions($payScale);
        });

        PayRoll::created(function(PayRoll $payRoll){
            $this->payRollOtherAmount($payRoll);
        });

        PayRoll::updated(function(PayRoll $payRoll){
            $this->payRollOtherAmount($payRoll);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }

    private function calculateDeductions(PayScale $pay_scale)
    {
        $nssf_bill = $pay_scale->basic_salary*0.1;
        $taxable = $pay_scale->basic_salary - $nssf_bill;
        $paye = null;

        if($taxable<= 270000) {
            $paye = 0;
        }

        if($taxable > 270000 && $taxable <=520000 ) {
            $paye = ($taxable-270000)*0.08;
        }

        if($taxable > 520000 && $taxable <=760000 ) {
            $paye = 2000 + ($taxable-520000)*0.2;
        }

        if($taxable > 760000 && $taxable <=1000000 ) {
            $paye = 68000 + ($taxable-760000)*0.25;
        }

        if($taxable > 1000000) {
            $paye = 128000 + ($taxable-1000000)*0.3;
        }

        $tax = Deduction::firstWhere('name', 'TAX');

        $nssf = Deduction::firstWhere('name', 'NSSF');

        $pay_scale->deductions()->detach($tax);
        $pay_scale->deductions()->detach($nssf);

        $pay_scale->deductions()->attach($tax->id,['amount' => $paye]);
        $pay_scale->deductions()->attach($nssf->id,['amount' => $nssf_bill]);
    }

    /**
     * @param PayRoll $payRoll
     */
    private function payRollOtherAmount(PayRoll $payRoll): void
    {
        $pay_scale = PayScale::firstWhere('id', $payRoll->id);

        if(!empty($pay_scale->deductions->toArray())) {

            foreach ($pay_scale->deductions as $deduction) {

                $payRoll->deductions()->detach($deduction);

                $payRoll->deductions()->attach($deduction->id, ['amount' => $deduction->pivot->amount]);
            }
        }

        if(!empty($pay_scale->allowances->toArray())) {

            foreach ($pay_scale->allowances as $allowance) {

                $payRoll->allowances()->detach($allowance);

                $payRoll->allowances()->attach($allowance->id, ['amount' => $allowance->pivot->amount]);
            }
        }

    }
}
