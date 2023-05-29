<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evenement extends Model
{
    use HasFactory;

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function evenement_type(): BelongsTo
    {
        return $this->belongsTo(EvenementType::class, 'evenement_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function getStartAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d/m/Y');
    // }

    // public function getEndAttribute($value)
    // {
    //     return Carbon::parse($value)->format('d/m/Y');
    // }
}
