<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produktua;
use App\Models\kategoria;
use App\Models\produktu_mugimendua;

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

    public function erakutsiMugimendua(){
        $emaitza = produktua::join('produktu_mugimendua', 'produktua.id', '=', 'produktu_mugimendua.id_produktua')
        ->groupBy('produktua.izena')
        ->select('produktua.izena', produktu_mugimendua::raw('SUM(produktu_mugimendua.kopurua) AS total_kopurua'))
        ->get();
        return json_encode($emaitza);
    }





}
