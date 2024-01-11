<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taldea;
use App\Models\langilea;

class alumnos_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = Langilea::select('langilea.izena', 'langilea.abizena', 'taldea.izena')
            ->join('taldea', 'taldea.kodea', '=', 'langilea.kodea')
            ->orderBy('taldea.izena', 'desc')
            ->get();
    
        return json_encode($emaitza);
    }
    

    public function ezabatu(Request $request){
        $datos = $request->all();
        $hoy = date('Y-m-d H:i:s');
        langilea::where('langilea.kodea', $datos["kodea"])->update(['ezabatze_data' => $hoy, 'eguneratze_data', $hoy]);
        return "allOk";
    }

    public function txertatu(Request $request){
        $datos = $request->all();
         langilea::insert([
             'kodea' =>  $datos["kodea"],
             'izena' =>  $datos["izena"],
             'abizena' => $datos["abizena"]
             // ... otras columnas y valores
         ]);
         return "allOkk";
    } 
 
    public function editatu(Request $request){
         $datos = $request->all();
         $hoy = date('Y-m-d H:i:s');
         langilea::where('langilea.kodea', $datos["kodea"])->update(['eguneratze_data' => $hoy, 'kodea' => $datos['kodea'], 'izena' => $datos['izena'], 'abizenak' => $datos['abizenak']]);
         return "allOkk";
    } 
}
