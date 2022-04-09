<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PayRoll extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function allowances(): BelongsToMany
    {
        return $this->belongsToMany(Allowance::class,'allowance_pay_roll','pay_roll_id','allowance_id')
            ->withPivot(['amount', 'created_at', 'updated_at']);
    }

    public function deductions(): BelongsToMany
    {
        return $this->belongsToMany(Deduction::class,'deduction_pay_roll', 'pay_roll_id','deduction_id')
            ->withPivot(['amount', 'created_at', 'updated_at']);
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function pay_scale(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class);
    }
}
