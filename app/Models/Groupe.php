<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Groupe extends Model
{
    use HasFactory, SoftDeletes;

    public function adherents(): BelongsToMany
    {
        return $this->belongsToMany(Adherent::class);
    }
}
