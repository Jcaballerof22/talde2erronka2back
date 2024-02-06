<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\langilea;
use App\Models\ordutegia;

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

        if($emaitza->isEmpty()){
            return response()->json(['message' => 'Ez dago daturik.'], 404);
        }else{
            return response()->json($emaitza, 200);
        }
    }
    

    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $emaitza = langilea::where('langilea.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        
        if($emaitza->isEmpty()){
            return response()->json(['message' => 'Ez da langilerik aurkitu.'], 404);
        }else{
            return response()->json(['message' => 'Langilea ezabatu da.'], 200);
        }
    }

    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $id = langilea::insertGetId([
            'kodea' =>  $datos["kodea"],
            'izena' =>  $datos["izena"],
            'abizenak' => $datos["abizenak"]
        ]);

        if($id){
            return response()->json(['message' => 'Langilea txertatu da.'], 200);
        }else{
            return response()->json(['message' => 'Langilea ez da txertatu.'], 400);
        }
    } 
 
    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        
        $emaitza = langilea::where('langilea.id', $datos["id"])
        ->update(['eguneratze_data' => $hoy, 'kodea' => $datos['kodea'], 
        'izena' => $datos['izena'], 'abizenak' => $datos['abizenak']]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Langilea editatu da.'], 200);
        } else {
            return response()->json(['message' => 'Ez dira aldaketarik egin.'], 400);
        }
    }

    public function langileFecha($fecha){
        // Para el json
        $eguna = date('N', strtotime($fecha));
        // Laconsulta
        $grupo = ordutegia::select('kodea')
        ->where('eguna', $eguna)
        ->whereDate('hasiera_data', '<=', $fecha)
        ->whereDate('amaiera_data', '>=', $fecha)
        ->get();
        if (isset($grupo[0])) {
            $emaitza = Langilea::select()
                ->where('kodea', $grupo[0]['kodea'])
                ->whereNull('ezabatze_data')
                ->orderBy('izena', 'asc')
                ->get();
            return response(json_encode($emaitza),200);
        }else{
            return response('No se encuentra el grupo',404);
        }
        
    }
}
