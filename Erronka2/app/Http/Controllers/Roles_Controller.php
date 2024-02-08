<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\txanda;
use App\Models\langilea;
use App\Models\taldea;

class Roles_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/roles/historial",
     *     tags={"Rolak"},
     *     summary="Rolen historiala lortzeko metodoa",
     *     @OA\Response(response="200", description="Rolen datuak lortu dira.")
     * )
     */
    // Rolen historiala lortzeko metodoa (langile bakoitza zenbat aldiz egon da rol bakoitzean)
    public function txandaHistorial(){
        $emaitza = txanda::join('langilea', 'txanda.id_langilea', '=', 'langilea.id')
        ->select('txanda.mota', 'txanda.data', 'langilea.izena', 'langilea.abizenak')
        ->orderByDesc('txanda.data')
        ->get();

        if ($emaitza->isNotEmpty()) {
            return response()->json($emaitza, 200);
        } else {
            return response()->json(['message' => 'Ez dira daturik lortu.'], 404);
        }
    }
    
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/roles/{taldea}",
     *     tags={"Rolak"},
     *     summary="Talde bateko langileek zenbat aldiz egon diren rol bakoitzean",
     *     @OA\Parameter(
     *         name="taldea",
     *         in="path",
     *         description="Taldearen izena",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Rolen datuak lortu dira.")
     * )
     */
    // Talde bateko langileek zenbat aldiz egon diren rol bakoitzean
    public function erakutsi($taldea){
        $id = taldea::where('izena', $taldea)->pluck('kodea');

        $emaitza = langilea::join('txanda', 'langilea.id', '=', 'txanda.id_langilea')
        ->select('langilea.izena', 'langilea.abizenak', 'txanda.id_langilea',
                langilea::raw('SUM(CASE WHEN txanda.mota = "M" THEN 1 ELSE 0 END) AS suma_m'),
                langilea::raw('SUM(CASE WHEN txanda.mota = "G" THEN 1 ELSE 0 END) AS suma_g'))
        ->where('langilea.kodea', '=', $id)
        ->groupBy('txanda.id_langilea', 'langilea.izena', 'langilea.abizenak')
        ->get();

        if ($emaitza->isNotEmpty()) {
            return response()->json($emaitza, 200);
        } else {
            return response()->json(['message' => 'Ez dira daturik lortu.'], 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/roles/pertsonak/{taldea}",
     *     tags={"Rolak"},
     *     summary="Talde bateko langile bakoitzak noiz egon den rol bakoitzean",
     *     @OA\Parameter(
     *         name="taldea",
     *         in="path",
     *         description="Taldearen izena",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Rolen datuak lortu dira.")
     * )
     */
    // Talde bateko langile bakoitzak noiz egon den rol bakoitzean
    public function erakutsiPertsonak($taldea){
        $id = taldea::where('izena', $taldea)->pluck('kodea');

        $emaitza = langilea::join('txanda', 'langilea.id', '=', 'txanda.id_langilea')
        ->select('langilea.izena', 'langilea.abizenak', 'txanda.id_langilea', 'txanda.data', 'txanda.mota', 'txanda.ezabatze_data',
                langilea::raw('SUM(CASE WHEN txanda.mota = "M" THEN 1 ELSE 0 END) AS suma_m'),
                langilea::raw('SUM(CASE WHEN txanda.mota = "G" THEN 1 ELSE 0 END) AS suma_g'))
        ->where('langilea.kodea', '=', $id)
        ->groupBy('txanda.id_langilea', 'langilea.izena', 'langilea.abizenak', 'txanda.data', 'txanda.mota', 'txanda.ezabatze_data')
        ->get();

        if ($emaitza->isNotEmpty()) {
            return response()->json($emaitza, 200);
        } else {
            return response()->json(['message' => 'Ez dira daturik lortu.'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/roles/ezabatu",
     *     tags={"Rolak"},
     *     summary="Rolak ezabatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id_langilea"},
     *                 @OA\Property(
     *                     property="id_langilea",
     *                     type="integer",
     *                     example="1",
     *                     description="Langilearen IDa"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Rolen datuak ezabatu dira.")
     * )
     */
    // Rolak ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        $emaitza = txanda::where('id_langilea', $datos["id_langilea"])
        ->where('data', $hoy)
        ->update(['ezabatze_data' => $hoy]);

        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak ezabatu.'], 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/roles/txertatu",
     *     tags={"Rolak"},
     *     summary="Rolak txertatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id_langilea", "mota"},
     *                 @OA\Property(
     *                     property="id_langilea",
     *                     type="integer",
     *                     example="1",
     *                     description="Langilearen IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="mota",
     *                     type="string",
     *                     enum={"M", "G"},
     *                     description="Rol mota ('M' edo 'G')"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Rolen datuak txertatu dira.")
     * )
     */
    // Rolak txertatzeko metodoa
    public function txertatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        $emaitza = txanda::insert([
            'data' => $hoy,
            'eguneratze_data' => $hoy,
            'id_langilea' => $datos["id_langilea"],
            'mota' => $datos["mota"],
            'sortze_data' => $hoy
        ]);

        if ($emaitza) {
            return response()->json(['message' => 'Datuak txertatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Datuak txertatu dira.'], 400);
        }    }
}
