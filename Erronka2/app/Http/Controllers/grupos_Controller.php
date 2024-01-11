<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\erabiltzailea;
use App\Models\langilea;
use App\Models\taldea;

class grupos_Controller extends Controller
{
    
    public function erakutsi() {
        $emaitza = taldea::select('taldea.izena', langilea::raw('COUNT(langilea.kodea) as langileak'))
        ->Leftjoin('langilea', 'taldea.kodea', '=', 'langilea.kodea')
        ->whereNull('taldea.ezabatze_data')
        ->groupBy('taldea.izena')
        ->orderBy('langileak', 'desc')
        ->get();
        return json_encode($emaitza);
    }

    public function ezabatu(Request $request){
        $datos = $request->all();
        $hoy = date('Y-m-d H:i:s');
        taldea::where('taldea.kodea', $datos["kodea"])->update(['ezabatze_data' => $hoy, 'eguneratze_data', $hoy]);
        return "allOk";
    }

    public function txertatu(Request $request){
       $datos = $request->all();
        taldea::insert([
            'kodea' =>  $datos["kodea"],
            'izena' =>  $datos["izena"]
            // ... otras columnas y valores
        ]);
        return "allOkk";
    } 

    public function editatu(Request $request){
        $datos = $request->all();
        $hoy = date('Y-m-d H:i:s');
        taldea::where('taldea.kodea', $datos["kodea"])->update(['eguneratze_data' => $hoy, 'kodea' => $datos['kodea'], 'izena' => $datos['izena']]);
        return "allOkk";
     } 
}