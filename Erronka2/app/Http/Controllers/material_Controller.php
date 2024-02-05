<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materiala;
use App\Models\materiala_erabili;
use App\Models\langilea;
use App\Models\taldea;

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

    public function erakutsiMugimenduak(){
        $emaitza = materiala_erabili::join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
        ->join('langilea', 'materiala_erabili.id_langilea', '=', 'langilea.id')
        ->select('materiala.izena AS materiala', 'langilea.izena', 'langilea.abizenak', 'materiala_erabili.hasiera_data', 'materiala_erabili.amaiera_data')
        ->get();
        return json_encode($emaitza);
    }

    public function reservar($id){
    
        $emaitza = langilea::join('materiala_erabili', 'langilea.id', '=', 'materiala_erabili.id_langilea')
            ->join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
            ->select('materiala_erabili.id', 'materiala_erabili.id_langilea', 'materiala_erabili.id_materiala', 'materiala_erabili.hasiera_data', 'materiala_erabili.amaiera_data')
            ->where('materiala_erabili.id_materiala', $id)
            ->orderByDesc('materiala_erabili.id')
            ->limit(1)
            ->get();
    
        if ($emaitza->isNotEmpty()) {
            return response()->json($emaitza);
        } else {
            $emaitza = [[
                    "id"=> "",
                    "id_langilea"=> "",
                    "id_materiala"=> "",
                    "hasiera_data"=> "",
                    "amaiera_data"=> ""
            ]];
            return response()->json($emaitza);
        }
    }

    public function devolver(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $ultimoRegistro = materiala_erabili::where('id_materiala', $datos["id_materiala"])
        ->latest("id");

        if ($ultimoRegistro) {
            // Actualizar la columna eguneratze_data del último registro encontrado
            $ultimoRegistro->update(['amaiera_data' => $hoy]);
            return "allOk";
        } else {
            // Manejar el caso en que no se encuentre ningún registro con ese materiala.id
            return "No se encontraron registros con el materiala.id proporcionado.";
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

    public function saberGrupo (){
        $emaitza = taldea::select(
            'kodea',
            'izena'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        return json_encode($emaitza);
    }

    public function saberAlumnos ($talde){
        $emaitza = langilea::select(
            'izena',
            'abizenak',
            'id'
        )
            ->where('kodea', $talde)
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        return json_encode($emaitza);
    }

    public function reservarMaterial(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $id = materiala_erabili::insertGetId([
            'id_materiala' => $datos["id_materiala"],
            'id_langilea' => $datos["id_langilea"],
            'hasiera_data' => $hoy,
            'amaiera_data' => null
        ]);
        return "JEIIII";
    }
 
    public function editatu(Request $request){
         $datos = $request->json()->all();
         $hoy = date('Y-m-d H:i:s');
         materiala::where('materiala.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'etiketa' => $datos['etiketa'], 'izena' => $datos['izena']]);
         return "allOkk";
    }
}

