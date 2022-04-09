<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PayScale extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function allowances(): BelongsToMany
    {
        return $this->belongsToMany(Allowance::class,'allowance_pay_scale','pay_scale_id','allowance_id')
                    ->withPivot(['amount', 'created_at', 'updated_at']);
    }

    public function deductions(): BelongsToMany
    {
        return $this->belongsToMany(Deduction::class,'deduction_pay_scale', 'pay_scale_id','deduction_id')
            ->withPivot(['amount', 'created_at', 'updated_at']);
    }
}
