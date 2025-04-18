<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Abonnement extends Model
{
    use HasFactory;


    public function adherent(): BelongsTo
    {
        return $this->belongsTo(Adherent::class);
    }
}
