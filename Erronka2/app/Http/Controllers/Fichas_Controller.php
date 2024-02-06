<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bezero_fitxa;

class Fichas_Controller extends Controller
{
    // Bezero fitxen datuak lortzeko metodoa
    public function erakutsi() {
        $emaitza = bezero_fitxa::whereNull('ezabatze_data')->get();
        return response()->json($emaitza);
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

        bezero_fitxa::where('id', $datos['id'])->update(['eguneratze_data' => $hoy, 'izena' => $datos['izena'], 'abizena' => $datos['abizena'], 'telefonoa' => $datos['telefonoa'], 'azal_sentikorra' => $azal_sentikorra]);
        return "allOkk";
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

        bezero_fitxa::insert([
            'izena' => $datos['izena'],
            'abizena' => $datos['abizena'],
            'telefonoa' => $datos['telefonoa'],
            'azal_sentikorra' => $azal_sentikorra,
            'eguneratze_data' => $hoy
        ]);
        return response()->json(['message' => 'Operación exitosa']);
    }

    // Fitxak ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        bezero_fitxa::where('id', $datos["id"])
        ->update(['ezabatze_data' => $hoy]);

        return response()->json(['message' => 'Operación exitosa']);
    }
}
