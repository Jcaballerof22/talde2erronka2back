<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taldea;
use App\Models\ordutegia;

class Ordutegia_Controller extends Controller
{
    public function erakutsi() {
        $emaitza = ordutegia::select('ordutegia.EGUNA', 'taldea.IZENA', 'ordutegia.HASIERA_DATA', 'ordutegia.AMAIERA_DATA')
        ->join('taldea', 'ordutegia.KODEA', '=', 'taldea.KODEA')
        ->get();
    
        return json_encode($emaitza);
    }

    public function editatu(Request $request){
        
        try{

            $datos = $request->json()->all();

            if (!isset($datos['izena']) || !isset($datos['eguna'])) {
                return response()->json(['error' => 'Datos incompletos'], 400);
            }

            $izena = $datos["izena"];
            $eguna = $datos["eguna"];

            $taldeaKodea = taldea::where('izena', $izena)->value('kodea');

            ordutegia::where('eguna', $eguna)
                ->update(['kodea' => $taldeaKodea]);

            return response()->json(['message' => 'Operación exitosa']);

        }catch (\Exception $e) {
            // Manejar errores
            \Log::error('Error en Ordutegia_Controller@editatu: ' . $e->getMessage());
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }
}

