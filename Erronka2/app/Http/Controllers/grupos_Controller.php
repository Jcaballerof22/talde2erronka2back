<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\erabiltzailea;
use App\Models\langilea;
use App\Models\taldea;

class grupos_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/grupos",
     *     tags={"Taldeak"},
     *     summary="Taldeen datuak lortu",
     *     @OA\Response(response="200", description="Taldeen datuak lortu dira.")
     * )
     */
    public function erakutsi() {
        $emaitza = taldea::select('taldea.izena', 'taldea.kodea', langilea::raw('COUNT(langilea.kodea) as langileak'))
        ->Leftjoin('langilea', 'taldea.kodea', '=', 'langilea.kodea')
        ->whereNull('taldea.ezabatze_data')
        ->groupBy('taldea.izena','taldea.kodea')
        ->orderBy('langileak', 'desc')
        ->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/grupos/ezabatu",
     *     tags={"Taldeak"},
     *     summary="Taldeak ezabatu",
     *     @OA\Response(response="200", description="Taldea ezabatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"kodea"},
     *                 @OA\Property(
     *                     property="kodea",
     *                     type="integer",
     *                     example="1",
     *                     description="Taldearen kodea"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = taldea::where('taldea.kodea', $datos["kodea"])
        ->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        
        if ($emaitza === false) {
            return response()->json(['message' => 'Ez dira daturik ezabatu.'], 400);
        } else {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/grupos/txertatu",
     *     tags={"Taldeak"},
     *     summary="Taldeak txertatu",
     *     @OA\Response(response="200", description="Taldea txertatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"izena"},
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="TaldeaIzena",
     *                     description="Taldearen izena"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function txertatu(Request $request){
        $datos = $request->json()->all();

        $id = taldea::insertGetId([
            'izena' =>  $datos["izena"]
            // ... otras columnas y valores
        ]);

        if ($id) {
            return response()->json(['id' => $id], 200);
        } else {
            return response()->json(['message' => 'Ez dira daturik txertatu.'], 400);
        }
    } 

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/grupos/editatu",
     *     tags={"Taldeak"},
     *     summary="Taldeak editatu",
     *     @OA\Response(response="200", description="Taldea editatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"kodea", "izena"},
     *                 @OA\Property(
     *                     property="kodea",
     *                     type="int",
     *                     example="1",
     *                     description="Taldearen kodea"
     *                 ),
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="TaldeaIzena",
     *                     description="Taldearen izena"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = taldea::where('taldea.kodea', $datos["kodea"])
        ->update([
            'eguneratze_data' => $hoy, 
            'kodea' => $datos['kodea'], 
            'izena' => $datos['izena']
        ]);

        if ($emaitza) {
            return response('Datuak editatu dira.', 200);
        } else {
            return response('Ezin izan dira datuak editatu.', 400);
        }
    } 

}