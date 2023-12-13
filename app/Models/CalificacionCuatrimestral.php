<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionCuatrimestral extends Model
{
    use HasFactory;
    public function usuarios(){
        return $this->belongsTo(Usuario::class);
    }
    public function calificacionesCuatrimestralesProcesadas(){
        return $this->hasMany(CalificacionCuatrimestralProcesada::class);
    }
}
