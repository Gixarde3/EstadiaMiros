<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BajaProcesada; // Import the missing class
use App\Models\Alumno;
class BajaProcesadaController extends Controller
{
    //
    public function getBajasByPeriodo(Request $request, $idCohorte){
        $bajas = BajaProcesada::join('alumnos', 'alumnos.id', '=', 'baja_procesadas.idAlumno')
        ->selectRaw('baja_procesadas.periodo, count(*) as total')
        ->where('alumnos.idCohorte', $idCohorte)
        ->groupBy('baja_procesadas.periodo')
        ->orderByRaw('(
            (CASE SUBSTR(baja_procesadas.periodo, 1, 1)
                WHEN "I" THEN 0.2
                WHEN "P" THEN 0.3
                WHEN "O" THEN 0.4
            END) + 
            SUBSTR(baja_procesadas.periodo, 2, 4)
        )')
        ->get();
        return response()->json([
            'success' => true,
            'resultados' => $bajas
        ]);
    }
    public function getBajas(Request $request, $idCohorte){
        $bajas = Alumno::leftjoin('baja_procesadas', 'baja_procesadas.idAlumno', '=', 'alumnos.id')
        ->selectRaw('SUM(IF(alumnos.activo, 1, 0)) as activos, 
            SUM(IF(alumnos.activo, 0, IF(baja_procesadas.bajaDefinitiva, 0, 1))) as temporal, 
            SUM(IF(alumnos.activo, 0, IF(baja_procesadas.bajaDefinitiva, 1, 0))) as definitiva')
        ->where('alumnos.idCohorte', $idCohorte)
        ->first();
        return response()->json([
            'success' => true,
            'resultados' => $bajas
        ]);
    }
    public function getBajasByRango(Request $request, $anio1, $anio2, $carrera)
    {
        if($anio1 > $anio2) 
            return response()->json(['success' => false, 'message' => 'El año 1 debe ser menor al año 2']);

        $bajas = BajaProcesada::join('alumnos', 'alumnos.id', '=', 'baja_procesadas.idAlumno')
        ->join('cohortes', 'cohortes.id', '=', 'alumnos.idCohorte')
        ->where('cohortes.anio', '>=', $anio1)
        ->where('cohortes.anio', '<=', $anio2)
        ->whereRaw("SUBSTR(cohortes.plan, 1, 3) = '$carrera'")
        ->groupByRaw("CONCAT(cohortes.periodo, cohortes.anio)")
        ->selectRaw("CONCAT(cohortes.periodo, cohortes.anio) as cohorte, COUNT(*) as total, SUM(IF(baja_procesadas.bajaDefinitiva, 1, 0)) as definitivas, SUM(IF(baja_procesadas.bajaDefinitiva, 0, 1)) as temporal")
        ->get();
        return response()->json([
            'success' => true,
            'resultados' => $bajas
        ]);
    }
    public function getAlumnos(Request $request, $idCohorte){
        $activos = Alumno::where('idCohorte', $idCohorte)
        ->count();
        return response()->json([
            'success' => true,
            'resultados' => $activos
        ]);
    }
}
