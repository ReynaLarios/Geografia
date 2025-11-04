<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarSeccion extends Model {
    use HasFactory;
    protected $fillable = ['nombre','orden','is_active'];

    public function contenidos() {
        return $this->hasMany(NavbarContenido::class);
    }
}
