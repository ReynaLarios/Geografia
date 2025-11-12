<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $fillable = [
        'archivable_id',
        'archivable_type',
        'nombre_real',
        'archivo',
    ];

    public function archivable()
    {
        return $this->morphTo();
    }
}