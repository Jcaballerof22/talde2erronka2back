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
        ]);
        return $id;
    } 
 
    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        langilea::where('langilea.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'kodea' => $datos['kodea'], 'izena' => $datos['izena'], 'abizenak' => $datos['abizenak']]);
        return "allOkk";
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
            return response('no se encuentra el grupo',404);
        }   
    }
    
}
