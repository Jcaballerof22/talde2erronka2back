<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\bezero_fitxa;

class Fichas_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/fichas",
     *     tags={"Fitxak"},
     *     summary="Fitxen datuak lortu",
     *     @OA\Response(response="200", description="Fitxen datuak lortu dira.")
     * )
     */
    // Bezero fitxen datuak lortzeko metodoa
    public function erakutsi() {
        $emaitza = bezero_fitxa::whereNull('ezabatze_data')->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira fitxarik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/fichas/editatu",
     *     tags={"Fitxak"},
     *     summary="Fitxak editatu",
     *     @OA\Response(response="200", description="Fitxa editatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "izena", "abizena", "telefonoa", "azal_sentikorra"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Juan"
     *                 ),
     *                 @OA\Property(
     *                     property="abizena",
     *                     type="string",
     *                     example="García"
     *                 ),
     *                 @OA\Property(
     *                     property="telefonoa",
     *                     type="string",
     *                     example="555123456"
     *                 ),
     *                 @OA\Property(
     *                     property="azal_sentikorra",
     *                     type="boolean",
     *                     example=true
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/fichas/txertatu",
     *     tags={"Fitxak"},
     *     summary="Fitxak txertatu",
     *     @OA\Response(response="200", description="Fitxa txertatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"izena", "abizena", "telefonoa", "azal_sentikorra"},
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Juan"
     *                 ),
     *                 @OA\Property(
     *                     property="abizena",
     *                     type="string",
     *                     example="García"
     *                 ),
     *                 @OA\Property(
     *                     property="telefonoa",
     *                     type="string",
     *                     example="555123456"
     *                 ),
     *                 @OA\Property(
     *                     property="azal_sentikorra",
     *                     type="boolean",
     *                     example=true
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/fichas/ezabatu",
     *     tags={"Fitxak"},
     *     summary="Fitxak ezabatu",
     *     @OA\Response(response="200", description="Fitxa ezabatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="1"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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
