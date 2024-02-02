<?php

use App\Http\Controllers\grupos_Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Grupos

Route::get('grupos','App\Http\Controllers\grupos_Controller@erakutsi');

Route::post('grupos/txertatu', 'App\Http\Controllers\grupos_Controller@txertatu');

Route::put('grupos/ezabatu', 'App\Http\Controllers\grupos_Controller@ezabatu');

Route::put('grupos/editatu', 'App\Http\Controllers\grupos_Controller@editatu');

// Alumnos

Route::get('alumnos','App\Http\Controllers\alumnos_Controller@erakutsi');

Route::post('alumnos/txertatu', 'App\Http\Controllers\alumnos_Controller@txertatu');

Route::put('alumnos/ezabatu', 'App\Http\Controllers\alumnos_Controller@ezabatu');

Route::put('alumnos/editatu', 'App\Http\Controllers\alumnos_Controller@editatu');

// Horarios

Route::get('horarios','App\Http\Controllers\Ordutegia_Controller@erakutsi');

Route::get('horarios/taldea','App\Http\Controllers\Ordutegia_Controller@erakutsiTaldea');

Route::post('horarios/txertatu', 'App\Http\Controllers\Ordutegia_Controller@txertatu');

Route::put('horarios/editatu', 'App\Http\Controllers\Ordutegia_Controller@editatu');

Route::put('horarios/ezabatu', 'App\Http\Controllers\Ordutegia_Controller@ezabatu');

//Hitzordua

Route::get('hitzordua/{fecha}','App\Http\Controllers\hitzordua_Controller@erakutsi'); 

// Tickets

Route::get('tickets','App\Http\Controllers\Tickets_Controller@erakutsi');

// Roles
Route::get('roles/historial','App\Http\Controllers\Roles_Controller@txandaHistorial');

Route::get('roles/{taldea}','App\Http\Controllers\Roles_Controller@erakutsi');

Route::get('roles/pertsonak/{taldea}','App\Http\Controllers\Roles_Controller@erakutsiPertsonak');

Route::post('roles/txertatu', 'App\Http\Controllers\Roles_Controller@txertatu');

Route::put('roles/ezabatu', 'App\Http\Controllers\Roles_Controller@ezabatu');

// Productos

Route::get('productos','App\Http\Controllers\Productos_Controller@erakutsi');

Route::get('productos/mugimendua','App\Http\Controllers\Productos_Controller@erakutsiMugimendua');

Route::get('productos/mugimenduguztiak','App\Http\Controllers\Productos_Controller@erakutsiMugimenduGuztiak');

Route::post('productos/txertatu', 'App\Http\Controllers\Productos_Controller@txertatu');

Route::put('productos/ezabatu', 'App\Http\Controllers\Productos_Controller@ezabatu');

Route::put('productos/editatu','App\Http\Controllers\Productos_Controller@editatu');

// Categorias

Route::get('kategoria','App\Http\Controllers\Categorias_Controller@erakutsi');

//Materiala

Route::get('materiala','App\Http\Controllers\material_Controller@erakutsi');

Route::get('materiala/erabili','App\Http\Controllers\material_Controller@erakutsiErabili');

Route::get('materiala/mugimenduak','App\Http\Controllers\material_Controller@erakutsiMugimenduak');

Route::post('materiala/txertatu','App\Http\Controllers\material_Controller@txertatu');

Route::put('materiala/editatu','App\Http\Controllers\material_Controller@editatu');

Route::put('materiala/ezabatu','App\Http\Controllers\material_Controller@ezabatu');

Route::get('materialaR','App\Http\Controllers\material_Controller@reservar');

Route::get('materialaF/{id}','App\Http\Controllers\material_Controller@reservar');

// Tratamenduak

Route::get('tratamenduak','App\Http\Controllers\tratamenduak_Controller@erakutsi'); 

Route::post('tratamenduak/add','App\Http\Controllers\tratamenduak_Controller@addhitzorduTratamendu'); 

Route::put('tratamenduak/remove','App\Http\Controllers\tratamenduak_Controller@removehitzorduTratamendu'); 

Route::get('tratamenduak/{hitzorduaId}','App\Http\Controllers\tratamenduak_Controller@hitzorduTratamendu'); 



