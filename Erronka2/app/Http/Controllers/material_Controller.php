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

    public function erakutsiErabili() {
        $emaitza = materiala::join('materiala_erabili', 'materiala.id', '=', 'materiala_erabili.id_materiala')
        ->groupBy('materiala.izena', 'materiala.etiketa')
        ->select('materiala.izena', 'materiala.etiketa', materiala_erabili::raw('COUNT(materiala_erabili.id) as count_id'))
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
    public function reservar(Request $request){

        $id = $request->input('id');

        $emaitza = langilea::join('materiala_erabili', 'langilea.id', '=', 'materiala_erabili.id_langilea')
        ->join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
        ->select('materiala_erabili.id', 'materiala_erabili.id_langilea', 'materiala_erabili.id_materiala', 'materiala_erabili.hasiera_data', 'materiala_erabili.amaiera_data')
        ->where('materiala_erabili.id_materiala', $id)
        ->orderByDesc('materiala_erabili.id')
        ->limit(1)
        ->get();



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

