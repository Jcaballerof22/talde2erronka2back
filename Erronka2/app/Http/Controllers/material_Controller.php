<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materiala;
use App\Models\materiala_erabili;

class material_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = materiala::select(
            'etiketa',
            'izena'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        return json_encode($emaitza);
    }
    

    // public function ezabatu(Request $request){
    //     $datos = $request->json()->all();
    //     $hoy = date('Y-m-d H:i:s');
    //     langilea::where('langilea.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
    //     return "allOk";
    // }

    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $id = materiala::insertGetId([
             'etiketa' =>  $datos["etiketa"],
             'izena' =>  $datos["izena"]
         ]);
         return $id;
    } 
 
    // public function editatu(Request $request){
    //      $datos = $request->json()->all();
    //      $hoy = date('Y-m-d H:i:s');
    //      langilea::where('langilea.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'kodea' => $datos['kodea'], 'izena' => $datos['izena'], 'abizenak' => $datos['abizenak']]);
    //      return "allOkk";
    // } 
}

