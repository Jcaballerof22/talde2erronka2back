<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materiala;
use App\Models\materiala_erabili;
use App\Models\langilea;

class material_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = materiala::select(
            'etiketa',
            'izena',
            'id'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        return json_encode($emaitza);
    }

    // public function reservar(){
    //     $emaitza = materiala_erabili::select(
    //         'hasiera_data',
    //         'amaiera_data',
    //         'id',
    //         'id_langilea',
    //         'id_materiala'
    //     )
    //     ->Leftjoin('langilea', 'id_langilea', '=', 'langilea.id')
    //     ->Leftjoin('materiala','id_materiala', '=', 'materiala.id')
    //     ->whereDate('sortze_data', '=', now()->toDateString())
    //     ->latest()
    //     ->first();
    //     return json_encode($emaitza);
    // }
    public function reservar(){
        $hoy = date('Y-m-d H:i:s');

    $emaitza = materiala_erabili::select(
        'materiala_erabili.hasiera_data as hasiera_data',
        'materiala_erabili.amaiera_data as amaiera_data',
        'materiala_erabili.id as id_materiala_erabili',
        'materiala_erabili.id_langilea',
        'materiala_erabili.id_materiala',
        'langilea.id as langilea_id',
        'materiala.id as materiala_id'
    )
    ->leftJoin('langilea', 'materiala_erabili.id_langilea', '=', 'langilea.id')
    ->leftJoin('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
    ->whereDate('materiala_erabili.sortze_data', '=', $hoy)
    ->latest('materiala_erabili.sortze_data')
    ->first();

    if ($emaitza) {
        return response()->json($emaitza);
    } else {
        return response()->json(['error' => 'No se encontraron resultados'], 404);
    }
}

    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        materiala::where('materiala.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        return "allOk";
    }

    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $id = materiala::insertGetId([
             'etiketa' =>  $datos["etiketa"],
             'izena' =>  $datos["izena"]
         ]);
         return $id;
    } 
 
    public function editatu(Request $request){
         $datos = $request->json()->all();
         $hoy = date('Y-m-d H:i:s');
         materiala::where('materiala.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'etiketa' => $datos['etiketa'], 'izena' => $datos['izena']]);
         return "allOkk";
    }
}

