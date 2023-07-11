<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Adherent extends Model
{
    use HasFactory;



    public function statut(): HasOne
    {
        return $this->hasOne(Statut::class, 'adherent_id');
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

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }

    public function reunions(): BelongsToMany
    {
        return $this->belongsToMany(Reunion::class);
    }

    public function abonnements(): HasMany
    {
        return $this->HasMany(Abonnement::class);
    }
}
