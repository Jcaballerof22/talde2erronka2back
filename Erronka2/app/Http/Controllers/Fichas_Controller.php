<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bezero_fitxa;

class Fichas_Controller extends Controller
{
    // Bezero fitxen datuak lortzeko metodoa
    public function erakutsi() {
        $emaitza = bezero_fitxa::whereNull('ezabatze_data')->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira fitxarik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    // Fitxak editatzeko metodoa
    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        if($datos['azal_sentikorra']){
            $azal_sentikorra = 'B';
        }else{
            $azal_sentikorra = 'E';
        }

        $emaitza = bezero_fitxa::where('id', $datos['id'])
        ->update([
            'eguneratze_data' => $hoy, 
            'izena' => $datos['izena'], 
            'abizena' => $datos['abizena'], 
            'telefonoa' => $datos['telefonoa'], 
            'azal_sentikorra' => $azal_sentikorra
        ]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak editatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ez dira editatzeko daturik aurkitu.'], 404);
        }
    } 

    // Fitxa berri bat txertatzeko metodoa
    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        if($datos['azal_sentikorra']){
            $azal_sentikorra = 'B';
        }else{
            $azal_sentikorra = 'E';
        }

        $emaitza = bezero_fitxa::insert([
            'izena' => $datos['izena'],
            'abizena' => $datos['abizena'],
            'telefonoa' => $datos['telefonoa'],
            'azal_sentikorra' => $azal_sentikorra,
            'eguneratze_data' => $hoy
        ]);

        if ($emaitza) {
            return response()->json(['message' => 'Datuak txertatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira daturik txertatu.'], 400);
        }
    }

    // Fitxak ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d');

        $emaitza = bezero_fitxa::where('id', $datos["id"])
        ->update(['ezabatze_data' => $hoy]);

        if ($emaitza) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira daturik ezabatu.'], 400);
        }    
    }
}
