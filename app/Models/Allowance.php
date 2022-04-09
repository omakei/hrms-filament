<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Allowance extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function payscales(): BelongsToMany
    {
        return $this->belongsToMany(PayScale::class,'allowance_pay_scale','allowance_id', 'pay_scale_id')
            ->withPivot(['amount', 'created_at', 'updated_at']);
    }
}
