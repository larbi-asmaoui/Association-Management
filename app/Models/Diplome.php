<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Diplome extends Model
{
    use HasFactory, SoftDeletes;

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class);
    }

    protected $casts = [
        'file_paths' => 'array',
    ];
}
