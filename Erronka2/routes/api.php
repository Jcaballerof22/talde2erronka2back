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

Route::get('alumnos/{fecha}','App\Http\Controllers\alumnos_Controller@langileFecha');

// Horarios

Route::get('horarios','App\Http\Controllers\Ordutegia_Controller@erakutsi');

Route::get('horarios/taldea','App\Http\Controllers\Ordutegia_Controller@erakutsiTaldea');

Route::post('horarios/txertatu', 'App\Http\Controllers\Ordutegia_Controller@txertatu');

Route::put('horarios/editatu', 'App\Http\Controllers\Ordutegia_Controller@editatu');

Route::put('horarios/ezabatu', 'App\Http\Controllers\Ordutegia_Controller@ezabatu');

//Hitzordua
Route::put('hitzordua/ezabatu','App\Http\Controllers\hitzordua_Controller@ezabatu'); 

Route::get('hitzordua/horduDisp/{data}/{hasiera_ordua}/{amaiera_ordua}','App\Http\Controllers\hitzordua_Controller@dispoHora'); 

Route::put('hitzordua/horduaHasiera','App\Http\Controllers\hitzordua_Controller@horduaHasiera'); 

Route::put('hitzordua/horduaAmaiera','App\Http\Controllers\hitzordua_Controller@horduaAmaiera'); 

Route::get('hitzordua/{fecha}','App\Http\Controllers\hitzordua_Controller@erakutsi'); 

Route::post('hitzordua/txertatu','App\Http\Controllers\hitzordua_Controller@txertatu'); 



// Tickets

Route::get('tickets','App\Http\Controllers\Tickets_Controller@erakutsi');

Route::put('tickets/editatu', 'App\Http\Controllers\Tickets_Controller@editatu');

Route::put('tickets/ezabatu', 'App\Http\Controllers\Tickets_Controller@ezabatu');

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

Route::post('productos/erosi', 'App\Http\Controllers\Productos_Controller@mugimenduBerria');


// Categorias

Route::get('kategoria','App\Http\Controllers\Categorias_Controller@erakutsi');

//Materiala


//'get' bidezko deia, rutan 'materiala' material_Controller kontroleadoreari deitzeko eta honetako 'erakutsi' funtzioari
Route::get('materiala','App\Http\Controllers\material_Controller@erakutsi');
//'get' bidezko deia, rutan 'materiala/erabili' material_Controller kontroleadoreari deitzeko eta honetako 'erakutsiErabili' funtzioari
Route::get('materiala/erabili','App\Http\Controllers\material_Controller@erakutsiErabili');
//'get' bidezko deia, rutan 'materiala/mugimenduak' material_Controller kontroleadoreari deitzeko eta honetako 'erakutsiMugimenduak' funtzioari
Route::get('materiala/mugimenduak','App\Http\Controllers\material_Controller@erakutsiMugimenduak');
//'post' bidezko deia, rutan 'materiala/txertatu' material_Controller kontroleadoreari deitzeko eta honetako 'txertatu' funtzioari
Route::post('materiala/txertatu','App\Http\Controllers\material_Controller@txertatu');
//'put' bidezko deia, rutan 'materiala/editatu' material_Controller kontroleadoreari deitzeko eta honetako 'editatu' funtzioari
Route::put('materiala/editatu','App\Http\Controllers\material_Controller@editatu');
//'put' bidezko deia, rutan 'materiala/ezabatu' material_Controller kontroleadoreari deitzeko eta honetako 'ezabatu' funtzioari
Route::put('materiala/ezabatu','App\Http\Controllers\material_Controller@ezabatu');
//'get' bidezko deia, rutan 'materialaF/{id}' material_Controller kontroleadoreari deitzeko eta honetako 'reservar' funtzioari
Route::get('materialaF/{id}','App\Http\Controllers\material_Controller@reservar');
//nuevo reservar
Route::get('materialaN','App\Http\Controllers\material_Controller@reservarNuevo');
//'post' bidezko deia, rutan 'materiala/reservar' material_Controller kontroleadoreari deitzeko eta honetako 'reservarMaterial' funtzioari
Route::post('materiala/reservar','App\Http\Controllers\material_Controller@reservarMaterial');
//'put' bidezko deia, rutan 'materiala/devolver' material_Controller kontroleadoreari deitzeko eta honetako 'devolver' funtzioari
Route::put('materiala/devolver','App\Http\Controllers\material_Controller@devolver');
//'get' bidezko deia, rutan 'materiala/grupos' material_Controller kontroleadoreari deitzeko eta honetako 'saberGrupo' funtzioari
Route ::get('materiala/grupos','App\Http\Controllers\material_Controller@saberGrupo');
//'get' bidezko deia, rutan 'materiala/alumnos/{kodea}' material_Controller kontroleadoreari deitzeko eta honetako 'saberAlumnos' funtzioari
Route::get('materiala/alumnos/{kodea}','App\Http\Controllers\material_Controller@saberAlumnos');

// Tratamenduak

Route::get('tratamenduak','App\Http\Controllers\tratamenduak_Controller@erakutsi');

Route::put('tratamenduak/ezabatu','App\Http\Controllers\tratamenduak_Controller@ezabatu');

Route::post('tratamenduak/txertatu','App\Http\Controllers\tratamenduak_Controller@txertatu');

Route::put('tratamenduak/editatu','App\Http\Controllers\tratamenduak_Controller@editatu');

Route::post('tratamenduak/add','App\Http\Controllers\tratamenduak_Controller@addhitzorduTratamendu'); 

Route::put('tratamenduak/remove','App\Http\Controllers\tratamenduak_Controller@removehitzorduTratamendu'); 

Route::get('tratamenduak/{hitzorduaId}','App\Http\Controllers\tratamenduak_Controller@hitzorduTratamendu'); 

// Fichas

Route::get('fichas','App\Http\Controllers\Fichas_Controller@erakutsi'); 

Route::put('fichas/editatu', 'App\Http\Controllers\Fichas_Controller@editatu');

Route::post('fichas/txertatu','App\Http\Controllers\Fichas_Controller@txertatu');

Route::put('fichas/ezabatu','App\Http\Controllers\Fichas_Controller@ezabatu');







