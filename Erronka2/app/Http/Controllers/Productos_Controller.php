<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produktua;
use App\Models\kategoria;

class Productos_Controller extends Controller
{
    //
    public function erakutsi(){
        $emaitza = Produktua::join('kategoria', 'kategoria.ID', '=', 'produktua.id_kategoria')
        ->select('produktua.id', 'produktua.izena', 'produktua.marka', 'produktua.deskribapena', 'produktua.stock', 'kategoria.izena as kategoria')
        ->orderBy('produktua.izena', 'asc')
        ->get();
        return json_encode($emaitza);
    }







}
