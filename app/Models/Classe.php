<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Classe extends Model
{
    use HasFactory;

    public function supervisors(): BelongsToMany
    {
        return $this->belongsToMany(Supervisor::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function adherents()
    {
        return $this->hasMany(Adherent::class);
    }
}
