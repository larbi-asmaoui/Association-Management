<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stock_type(): BelongsTo
    {
        return $this->belongsTo(StockType::class, 'stock_type_id');
    }

    public function getPurchaseDateAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }
}
