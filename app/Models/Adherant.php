<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adherant extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cotisations(): HasMany
    {
        return $this->HasMany(Cotisation::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getDateOfMembershipAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }
}
