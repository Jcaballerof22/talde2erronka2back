<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hitzordua;
class hitzordua_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/hitzordua/{fecha}",
     *     tags={"Hitzorduak"},
     *     summary="Hitzorduen datuak lortu",
     *     @OA\Parameter(
     *         name="fecha",
     *         in="path",
     *         required=true,
     *         description="Fecha de los hitzorduak en el formato YYYY-MM-DD",
     *         @OA\Schema(
     *             type="string",
     *             format="date",
     *             example="2024-02-10"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Hitzorduen datuak lortu dira.")
     * )
     */
    public function erakutsi($fecha) {
        $simbol = '=';
        if (strpos($fecha, "+")){
            $fecha = str_replace("+", "", $fecha);
            $simbol = '>=';
        }

        // $emaitza = hitzordua::select()
        //     ->whereNull('ezabatze_data')
        //     ->where('data', $simbol, $fecha)
        //     ->orderBy('hasiera_ordua', 'asc')
        //     ->get();
        // return json_encode($emaitza);

        $emaitza = hitzordua::select('hitzordua.*', 'langilea.izena as izena_langilea', 'taldea.izena as izena_taldea')
            ->join('langilea', 'hitzordua.id_langilea', '=', 'langilea.id')
            ->join('taldea', 'langilea.kodea', '=', 'taldea.kodea')
            ->whereNull('hitzordua.ezabatze_data')
            ->where('hitzordua.data', $simbol, $fecha)
            ->orderBy('hitzordua.hasiera_ordua', 'asc')
            ->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 400);
        }else{
            return json_encode($emaitza, 200);
        }
        

    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/hitzordua/ezabatu",
     *     tags={"Hitzorduak"},
     *     summary="Hitzorduak ezabatu",
     *     @OA\Response(response="200", description="Hitzordua ezabatu da."),
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
     *                     example=1,
     *                     description="Ezabatu nahi den hitzorduaren IDa"
     *                 ),
     *             )
     *         )
     *     )
     * )
     */
    public function ezabatu(Request $request) {
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = hitzordua::where('hitzordua.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak ezabatu.'], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/hitzordua/horduaHasiera",
     *     tags={"Hitzorduak"},
     *     summary="Hitzorduen hasiera ordua editatu",
     *     @OA\Response(response="200", description="Hasiera ordua editatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "ordua"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Hitzorduaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="ordua",
     *                     type="string",
     *                     description="Hitzorduaren hasiera ordua"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function horduaHasiera(Request $request) {
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        
        $emaitza = hitzordua::where('hitzordua.id', $datos["id"])->update(['hasiera_ordua_erreala' => $datos["ordua"], 'eguneratze_data' => $hoy]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak aldatu dira'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak aldatu.'], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/hitzordua/horduaAmaiera",
     *     tags={"Hitzorduak"},
     *     summary="Hitzorduen amaiera ordua editatu",
     *     @OA\Response(response="200", description="Amaiera ordua editatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "ordua"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     description="Hitzorduaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="ordua",
     *                     type="string",
     *                     description="Hitzorduaren amaiera ordua"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function horduaAmaiera(Request $request) {
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = hitzordua::where('hitzordua.id', $datos["id"])->update(['amaiera_ordua_erreala' => $datos["ordua"], 'eguneratze_data' => $hoy]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak aldatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak aldatu.'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/hitzordua/horduDisp/{data}/{hasiera_ordua}/{amaiera_ordua}",
     *     tags={"Hitzorduak"},
     *     summary="Hitzordu libreak lortu",
     *     @OA\Response(response="200", description="Datuak lortu dira."),
     *     @OA\Parameter(
     *         name="data",
     *         in="path",
     *         required=true,
     *         description="Hitzorduaren data (YYYY-MM-DD formatuan)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="hasiera_ordua",
     *         in="path",
     *         required=true,
     *         description="Hitzorduaren hasiera ordua (HH:MM formatuan)",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="amaiera_ordua",
     *         in="path",
     *         required=true,
     *         description="Hitzorduaren amaiera ordua (HH:MM formatuan)",
     *         @OA\Schema(type="string")
     *     )
     * )
     */
    public function dispoHora($data, $hasiera_ordua, $amaiera_ordua){
        $emaitza = hitzordua::select()
        ->whereNull('hitzordua.ezabatze_data')
        ->where('hitzordua.amaiera_ordua', '>=', $amaiera_ordua)
        ->where('hitzordua.hasiera_ordua', '<=', $hasiera_ordua)
        ->where('hitzordua.data', "=", $data)
        ->get();
        return json_encode($emaitza);
        
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/hitzordua/txertatu",
     *     tags={"Hitzorduak"},
     *     summary="Hitzorduak txertatu",
     *     @OA\Response(response="200", description="Hitzordua txertatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"izena", "telefonoa", "deskribapena", "hasiera_ordua", "amaiera_ordua", "langilea", "data"},
     *                 @OA\Property(property="izena", type="string"),
     *                 @OA\Property(property="telefonoa", type="string"),
     *                 @OA\Property(property="deskribapena", type="string"),
     *                 @OA\Property(property="hasiera_ordua", type="string", format="time"),
     *                 @OA\Property(property="amaiera_ordua", type="string", format="time"),
     *                 @OA\Property(property="langilea", type="integer"),
     *                 @OA\Property(property="etxekoa", type="boolean"),
     *                 @OA\Property(property="data", type="string", format="date"),
     *             )
     *         )
     *     )
     * )
     */
    public function txertatu(Request $request){
        $datos = $request->json()->all();
        if ($datos["etxekoa"]) {
            $etxekoa = 'E';
        }else {
            $etxekoa = 'K';
        }
        $id = hitzordua::insertGetId([
            'izena'=> $datos["izena"],
            'telefonoa'=> $datos["telefonoa"],
            'eserlekua'=> 0,
            'deskribapena'=> $datos["deskribapena"],
            'hasiera_ordua'=> $datos["hasiera_ordua"],
            'amaiera_ordua'=> $datos["amaiera_ordua"],
            'id_langilea'=> $datos["langilea"],
            'etxekoa'=> $etxekoa,
            'data'=> $datos["data"],
        ]);
        return $id;
    }

}