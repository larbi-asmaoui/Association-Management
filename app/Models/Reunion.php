<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reunion extends Model
{
    use HasFactory, SoftDeletes;



    public function reunion_type(): BelongsTo
    {
        return $this->belongsTo(ReunionType::class);
    }

    public function adherents(): BelongsToMany
    {
        return $this->belongsToMany(Adherent::class);
    }
}
