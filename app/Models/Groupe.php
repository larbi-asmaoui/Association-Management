<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Groupe extends Model
{
    use HasFactory;

    public function adherents(): BelongsToMany
    {
        return $this->belongsToMany(Adherent::class);
    }
}
