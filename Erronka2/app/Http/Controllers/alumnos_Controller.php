<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\langilea;

class alumnos_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = Langilea::select(
            'izena',
            'abizenak',
            'kodea',
            'id'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        return json_encode($emaitza);
    }
    

    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        langilea::where('langilea.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        return "allOk";
    }

    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $id = langilea::insertGetId([
             'kodea' =>  $datos["kodea"],
             'izena' =>  $datos["izena"],
             'abizenak' => $datos["abizenak"]
             // ... otras columnas y valores
         ]);
         return $id;
    } 
 
    public function editatu(Request $request){
         $datos = $request->json()->all();
         $hoy = date('Y-m-d H:i:s');
         langilea::where('langilea.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'kodea' => $datos['kodea'], 'izena' => $datos['izena'], 'abizenak' => $datos['abizenak']]);
         return "allOkk";
    } 
}
