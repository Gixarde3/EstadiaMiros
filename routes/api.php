<?php

use App\Http\Controllers\CohorteController;
use App\Http\Controllers\GrupoController; // Import the missing class
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Models\CalificacionCuatrimestral;
use App\Http\Controllers\CalificacionCuatrimestralController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [LoginController::class, 'login']);
Route::post('/sendMail', [LoginController::class, 'sendRestoreMail']);
Route::post('/restorePassword/{hash}', [LoginController::class, 'restorePassword']);
Route::post('/verifyHash/{hash}', [LoginController::class, 'verifyHash']);

Route::controller(UsuarioController::class)->group(function(){
    Route::get('user/{hash}', 'getUserByHash');
    Route::post('register','register');
    Route::get('usuarios','getAllUsers');
    Route::get('usuario/{id}','getUserById');
    Route::post('usuario/edit/{id}','editUser');
    Route::post('usuario/delete/{id}','deleteUser');
});

Route::controller(CohorteController::class)->group(function(){
    Route::post('cohorte','createCohorte');
    Route::post('cohorte/edit/{id}','editCohorte');
    Route::post('cohorte/delete/{id}','deleteCohorte');
    Route::get('cohortes','getAllCohortes');
    Route::get('cohorte/{id}','getCohorteById');
});

Route::controller(CalificacionCuatrimestralController::class)->group(function(){
    Route::get('calificaciones','calificaciones');
    Route::get('calificacion/{id}','getCalificacionById');
    Route::post('calificacion','subirCalificacion');
    Route::post('calificacion/{id}','actualizarCalificaciones');
    Route::post('calificacion/delete/{id}','eliminarCalificaciones');
    Route::get('calificacion/download/{fileName}','download');
});

Route::controller(GrupoController::class)->group(function(){ // The undefined type 'GrupoController' is now defined
    Route::post('grupo','crearGrupo');
    Route::post('grupo/edit/{id}','editarGrupo');
    Route::post('grupo/delete/{id}','eliminarGrupo');
    Route::get('grupos','getGrupos');
    Route::get('grupo/{id}','getGrupoById');
    Route::get('grupo/grado/{grado}','getGrupoByGrado');
    Route::get('grupo/periodo/{periodo}','getGrupoByPeriodo');
    Route::get('grupo/grupo/{grupo}','getGrupoByGrupo');
    Route::get('grupo/fecha/{fecha}','getGrupoByFecha');
});
