<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supervisor extends Model
{
    use HasFactory;

    public function classess(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class);
    }
}
