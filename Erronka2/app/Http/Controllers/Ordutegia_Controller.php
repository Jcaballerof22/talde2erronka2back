<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taldea;
use App\Models\ordutegia;

class Ordutegia_Controller extends Controller
{
    // Ordutegien datuak lortzeko metodoa
    public function erakutsi() {
        $emaitza = ordutegia::select('ordutegia.EGUNA', 'taldea.IZENA', 'ordutegia.HASIERA_DATA', 'ordutegia.AMAIERA_DATA', 'ordutegia.EZABATZE_DATA')
        ->join('taldea', 'ordutegia.KODEA', '=', 'taldea.KODEA')
        ->get();
    
        return json_encode($emaitza);
    }

    // Zein talde dagoen gaur lortzeko metodoa
    public function erakutsiTaldea(){
        $eguna = date('N');

        $emaitza = ordutegia::join('taldea', 'taldea.kodea', '=', 'ordutegia.kodea')
        ->where('ordutegia.eguna', $eguna)
        ->whereNull('ordutegia.ezabatze_data')
        ->select('taldea.izena')
        ->get();

        return json_encode($emaitza);
    }

    // Ordutegia editatzeko metodoa
    public function editatu(Request $request){
        
        try{

            $datos = $request->json()->all();

            if (!isset($datos['izena']) || !isset($datos['eguna'])) {
                return response()->json(['error' => 'Datos incompletos'], 400);
            }

            $izena = $datos["izena"];
            $eguna = $datos["eguna"];
            $fechaInicio = $datos["fechaInicio"];
            $fechaFin = $datos["fechaFin"];

            $taldeaKodea = taldea::where('izena', $izena)->value('kodea');

            ordutegia::where('eguna', $eguna)
                ->update(['kodea' => $taldeaKodea, 'hasiera_data' => $fechaInicio, 'amaiera_data' => $fechaFin]);

            return response()->json(['message' => 'Operación exitosa']);

        }catch (\Exception $e) {
            \Log::error('Error en Ordutegia_Controller@editatu: ' . $e->getMessage());
            return response()->json(['error' => 'Error en el servidor'], 500);
        }
    }

    // Ordutegia ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        ordutegia::where('eguna', $datos["eguna"])
        ->update([
            'eguneratze_data' => $hoy,
            'ezabatze_data' => $hoy
        ]);
        return response()->json(['message' => 'Operación exitosa']);
    }

    // Ordutegi berri bat txertatzeko metodoa
    public function txertatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');
        $izena = $datos["izena"];
        $taldeaKodea = taldea::where('izena', $izena)->value('kodea');
        $eguna = $datos["eguna"];
        $fechaInicio = $datos["fechaInicio"];
        $fechaFin = $datos["fechaFin"];

        ordutegia::insert([
            'kodea' => $taldeaKodea,
            'eguna' => $eguna,
            'hasiera_data' => $fechaInicio,
            'amaiera_data' => $fechaFin,
            'eguneratze_data' => $hoy,
            'hasiera_ordua' => "00:00:00",
            'amaiera_ordua' => "00:00:00"
        ]);
        return response()->json(['message' => 'Operación exitosa']);
    }
}

