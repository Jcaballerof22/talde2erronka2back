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

// Ordutegia

Route::get('horarios','App\Http\Controllers\Ordutegia_Controller@erakutsi');

Route::put('horarios/editatu', 'App\Http\Controllers\Ordutegia_Controller@editatu');

//Hitzordua

Route::get('hitzordua','App\Http\Controllers\hitzordua_Controller@erakutsi');