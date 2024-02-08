<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taldea;
use App\Models\ordutegia;

class Ordutegia_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/horarios",
     *     tags={"Ordutegia"},
     *     summary="Ordutegien datuak lortu",
     *     @OA\Response(response="200", description="Ordutegien datuak lortu dira.")
     * )
     */
    // Ordutegien datuak lortzeko metodoa
    public function erakutsi() {
        $emaitza = ordutegia::select('ordutegia.EGUNA', 'taldea.IZENA', 'ordutegia.HASIERA_DATA', 'ordutegia.AMAIERA_DATA', 'ordutegia.EZABATZE_DATA')
        ->join('taldea', 'ordutegia.KODEA', '=', 'taldea.KODEA')
        ->get();
    
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/horarios/taldea",
     *     tags={"Ordutegia"},
     *     summary="Zein talde dagoen gaur lortzeko metodoa",
     *     @OA\Response(response="200", description="Ordutegien datuak lortu dira.")
     * )
     */
    // Zein talde dagoen gaur lortzeko metodoa
    public function erakutsiTaldea(){
        $eguna = date('N');

        $emaitza = ordutegia::join('taldea', 'taldea.kodea', '=', 'ordutegia.kodea')
        ->where('ordutegia.eguna', $eguna)
        ->whereNull('ordutegia.ezabatze_data')
        ->select('taldea.izena')
        ->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/horarios/editatu",
     *     tags={"Ordutegia"},
     *     summary="Ordutegia editatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"izena", "eguna", "fechaInicio", "fechaFin"},
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="example_izena",
     *                     description="Taldearen izena"
     *                 ),
     *                 @OA\Property(
     *                     property="eguna",
     *                     type="string",
     *                     example="example_eguna",
     *                     description="Eguna"
     *                 ),
     *                 @OA\Property(
     *                     property="fechaInicio",
     *                     type="string",
     *                     example="2024-02-15 08:00:00",
     *                     description="Hasiera data"
     *                 ),
     *                 @OA\Property(
     *                     property="fechaFin",
     *                     type="string",
     *                     example="2024-02-15 17:00:00",
     *                     description="Amaiera data"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ordutegien datuak editatu dira.")
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/horarios/ezabatu",
     *     tags={"Ordutegia"},
     *     summary="Ordutegia ezabatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"eguna"},
     *                 @OA\Property(
     *                     property="eguna",
     *                     type="string",
     *                     example="2024-02-15",
     *                     description="Eguna"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ordutegien datuak ezabatu dira.")
     * )
     */
    // Ordutegia ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = ordutegia::where('eguna', $datos["eguna"])
        ->update([
            'eguneratze_data' => $hoy,
            'ezabatze_data' => $hoy
        ]);

        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ez dira daturik ezabatu.'], 404);
        }    
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/horarios/txertatu",
     *     tags={"Ordutegia"},
     *     summary="Ordutegia txertatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"izena", "eguna", "fechaInicio", "fechaFin"},
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Taldea1",
     *                     description="Taldearen izena"
     *                 ),
     *                 @OA\Property(
     *                     property="eguna",
     *                     type="int",
     *                     format="date",
     *                     example="1",
     *                     description="Ordutegiaren eguna"
     *                 ),
     *                 @OA\Property(
     *                     property="fechaInicio",
     *                     type="string",
     *                     format="date",
     *                     example="2024-02-15",
     *                     description="Ordutegiaren hasiera data"
     *                 ),
     *                 @OA\Property(
     *                     property="fechaFin",
     *                     type="string",
     *                     format="date",
     *                     example="2024-02-15",
     *                     description="Ordutegiaren amaiera data"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ordutegien datuak txertatu dira.")
     * )
     */
    // Ordutegi berri bat txertatzeko metodoa
    public function txertatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');
        $izena = $datos["izena"];
        $taldeaKodea = taldea::where('izena', $izena)->value('kodea');
        $eguna = $datos["eguna"];
        $fechaInicio = $datos["fechaInicio"];
        $fechaFin = $datos["fechaFin"];

        $emaitza = ordutegia::insert([
            'kodea' => $taldeaKodea,
            'eguna' => $eguna,
            'hasiera_data' => $fechaInicio,
            'amaiera_data' => $fechaFin,
            'eguneratze_data' => $hoy,
            'hasiera_ordua' => "00:00:00",
            'amaiera_ordua' => "00:00:00"
        ]);

        if ($emaitza) {
            return response()->json(['message' => 'Datuak txertatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ez dira datuak txertatu.'], 400);
        }
    }
}

