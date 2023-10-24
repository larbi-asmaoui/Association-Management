<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    use HasFactory;

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    protected $casts = [
        'file_paths' => 'array',
    ];
}
