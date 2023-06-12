<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Adherent extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statut(): BelongsTo
    {
        return $this->belongsTo(Statut::class);
    }

    public function cotisations(): HasMany
    {
        return $this->HasMany(Cotisation::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getDateOfBirthAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function getDateOfMembershipAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d');
    }

    public function groupes(): BelongsToMany
    {
        return $this->belongsToMany(Groupe::class);
    }

    public function evenements(): BelongsToMany
    {
        return $this->belongsToMany(Evenement::class);
    }
}
