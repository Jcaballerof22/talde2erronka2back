<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\langilea;
use App\Models\ordutegia;

class alumnos_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/alumnos",
     *     tags={"Langileak"},
     *     summary="Langileen datuak lortu",
     *     @OA\Response(response="200", description="Langileen datuak")
     * )
     */
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
    
    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/alumnos/ezabatu",
     *     tags={"Langileak"},
     *     summary="Langileak ezabatu",
     *     @OA\Response(response="200", description="Langilea ezabatu da"),
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
     *                     example="6"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $emaitza = langilea::where('langilea.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        
        if($emaitza > 0){
            return response()->json(['message' => 'Ez da langilerik aurkitu.'], 404);
        }else{
            return response()->json(['message' => 'Langilea ezabatu da.'], 200);
        }
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/alumnos/txertatu",
     *     tags={"Langileak"},
     *     summary="Langileak txertatu",
     *     @OA\Response(response="200", description="Langilea txertatu da"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
 *                 type="object",
 *                 required={"kodea", "izena", "abizenak"},
 *                 @OA\Property(
 *                     property="kodea",
 *                     type="integer",
 *                     example="1"
 *                 ),
 *                 @OA\Property(
 *                     property="izena",
 *                     type="string",
 *                     example="John"
 *                 ),
 *                 @OA\Property(
 *                     property="abizenak",
 *                     type="string",
 *                     example="Doe"
 *                 )
 *             )
     *         )
     *     )
     * )
     */
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
 
    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/alumnos/editatu",
     *     tags={"Langileak"},
     *     summary="Langileak editatu",
     *     @OA\Response(response="200", description="Langilea editatu da"),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "kodea", "izena", "abizenak"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example=1
     *                 ),
     *                 @OA\Property(
     *                     property="kodea",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="John"
     *                 ),
     *                 @OA\Property(
     *                     property="abizenak",
     *                     type="string",
     *                     example="Doe"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/alumnos/{fecha}",
     *     tags={"Langileak"},
     *     summary="Langileak lortu",
     *     @OA\Parameter(
     *         name="data",
     *         in="path",
     *         description="Data",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="2024-02-08"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Langilea lortu da")
     * )
     */
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
