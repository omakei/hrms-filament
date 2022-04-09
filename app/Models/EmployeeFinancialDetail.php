<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeFinancialDetail extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function salary_type(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class);
    }

    public function pay_scale(): BelongsTo
    {
        return $this->belongsTo(SalaryType::class);
    }

}
