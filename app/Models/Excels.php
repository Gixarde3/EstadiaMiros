<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excels extends Model
{
    use HasFactory;

    public function CalificacionCuatrimestral(){
        return $this->hasMany(CalificacionCuatrimestral::class);
    }
}
