<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Cohorte;

class CohorteController extends Controller
{
    
    /**
         * Crea un nuevo Cohorte.
         *
         * @param Request $request El objeto de solicitud HTTP.
         * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene el estado de éxito y el mensaje.
         */

    public function createCohorte(Request $request){

        $admin = Usuario::where('token',$request->token)->where('tipoUsuario','>=', 3)->first();
        if ($admin) {
            $newCohorte = new Cohorte();
            $newCohorte->periodo = $request->periodo;
            $newCohorte->anio = $request->anio;
            $newCohorte->plan = $request->plan;
            $newCohorte->idCreador = $admin->id;
            $newCohorte->save();
            $success = true;
            $message = 'Cohorte registrado correctamente';
        }else{
            $success = false;
            $message = "No cuentas con los permisos necesarios";
        }
        
        return response()->json([
            'success'=> $success,
            'message'=>$message
        ]);
    }
    
    /**
     * Edita un cohorte existente.
     *
     * @param Request $request La solicitud HTTP recibida.
     * @param int $id El ID del cohorte a editar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON con el resultado de la operación.
     */
    public function editCohorte(Request $request, $id){
        $admin = Usuario::where('token',$request->token)->where('tipoUsuario','>=', 3)->first();
        if ($admin) {
            $cohort = Cohorte::find($id);
            $cohort->periodo = $request->periodo;
            $cohort->anio = $request->anio;
            $cohort->plan = $request->plan;
            $cohort->save();
            $success = true;
            $message = 'Cohorte editado correctamente';
        }else{
            $success = false;
            $message = "No cuentas con los permisos necesarios";
        }
        
        return response()->json([
            'success'=> $success,
            'message'=>$message
        ]);
    }
    /**
     * Elimina un cohorte.
     *
     * @param Request $request La solicitud HTTP recibida.
     * @param int $id El ID del cohorte a eliminar.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que indica si se eliminó correctamente el cohorte.
     */
    public function deleteCohorte(Request $request, $id){
        $admin = Usuario::where('token',$request->token)->where('tipoUsuario','>=', 3)->first();
        if ($admin) {
            $cohort = Cohorte::find($id);
            $cohort->delete();
            $success = true;
            $message = 'Cohorte eliminado correctamente';
        }else{
            $success = false;
            $message = "No cuentas con los permisos necesarios";
        }
        
        return response()->json([
            'success'=> $success,
            'message'=>$message
        ]);
    }

    /**
     * Obtiene todos los cohortes.
     *
     * @param Request $request La solicitud HTTP recibida.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene todos los cohortes obtenidos.
     */
    public function getAllCohortes(Request $request){
        $cohortes = Cohorte::all();
        $success = true;
        $message = 'Cohortes obtenidos correctamente';
        return response()->json([
            'success'=> $success,
            'cohortes'=>$cohortes,
            'message'=>$message
        ]);
    }

    /**
     * Obtiene un cohorte por su ID.
     *
     * @param Request $request La solicitud HTTP recibida.
     * @param int $id El ID del cohorte a obtener.
     * @return \Illuminate\Http\JsonResponse La respuesta JSON que contiene el cohorte obtenido.
     */
    public function getCohorteById(Request $request, $id){
        $cohorte = Cohorte::find($id);
        $success = true;
        $message = 'Cohorte obtenido correctamente';
        return response()->json([
            'success'=> $success,
            'cohorte'=>$cohorte,
            'message'=>$message
        ]);
    }
}
