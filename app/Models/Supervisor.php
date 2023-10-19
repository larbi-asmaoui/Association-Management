<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supervisor extends Model
{
    use HasFactory;

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class);
    }

    public function diplomes(): HasMany
    {
        return $this->HasMany(Diplome::class);
    }
}
