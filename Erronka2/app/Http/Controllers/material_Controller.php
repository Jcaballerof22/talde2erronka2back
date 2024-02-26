<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materiala;
use App\Models\materiala_erabili;
use App\Models\langilea;
use App\Models\taldea;

class material_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala",
     *     tags={"Materiala"},
     *     summary="Materialen datuak lortu",
     *     @OA\Response(response="200", description="Materialen datuak lortu dira.")
     * )
     */
    //Taulan erakusteko datuak lortzen dituen Select-a, kontuan izanda "ezabatze_data" = null bada ez agertzea, ezabaketa logikoa
    public function erakutsi() {
        $emaitza = materiala::select(
            'etiketa',
            'izena',
            'id'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
        
        // Bueltatzen duena json bat da gero front-ak irakurtzeko  
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/erabili",
     *     tags={"Materiala"},
     *     summary="Zenbat bider erabili diren materialak",
     *     @OA\Response(response="200", description="Materialen datuak lortu dira.")
     * )
     */
    // Kontuan izateko zenbat bider erabili diren materialak historialean, Select bat Count batekin
    public function erakutsiErabili() {
        $emaitza = materiala::join('materiala_erabili', 'materiala.id', '=', 'materiala_erabili.id_materiala')
        ->groupBy('materiala.izena', 'materiala.etiketa')
        ->select('materiala.izena', 'materiala.etiketa', materiala_erabili::raw('COUNT(materiala_erabili.id) as count_id'))
        ->get();

        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dago daturik.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/mugimenduak",
     *     tags={"Materiala"},
     *     summary="Materiala nork izan duen",
     *     @OA\Response(response="200", description="Materialen datuak lortu dira.")
     * )
     */
    // Kontuan izateko materiala nork izan duen eta beraien mugimenduak historialean, Select bat erabilita
    public function erakutsiMugimenduak(){
        $emaitza = materiala_erabili::join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
        ->join('langilea', 'materiala_erabili.id_langilea', '=', 'langilea.id')
        ->select(
            'materiala.izena AS materiala', 
            'langilea.izena', 
            'langilea.abizenak', 
            'materiala_erabili.hasiera_data', 
            'materiala_erabili.amaiera_data')
        ->get();

        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dago daturik.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/materialaF/{id}",
     *     tags={"Materiala"},
     *     summary="Jakin ahal izateko material bat libre edo okupaturik dagoen",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Materialaren IDa"
     *     ),
     *     @OA\Response(response="200", description="Materialen datuak lortu dira.")
     * )
     */
    // Jakin ahal izateko material bat libre edo okupaturik dagoen, ez bada inoiz erreserbatu, hutsik bueltatuko du fron-era, Select bat baldintza desberdinekin eta bakarrik erregistro bat hartzen duena, id handiena duena
    public function reservar($id){
    
        $emaitza = langilea::join('materiala_erabili', 'langilea.id', '=', 'materiala_erabili.id_langilea')
            ->join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
            ->select(
                'materiala_erabili.id', 
                'materiala_erabili.id_langilea', 
                'materiala_erabili.id_materiala', 
                'materiala_erabili.hasiera_data', 
                'materiala_erabili.amaiera_data')
            ->where('materiala_erabili.id_materiala', $id)
            ->orderByDesc('materiala_erabili.id')
            ->limit(1)
            ->get();
    
        if ($emaitza->isNotEmpty()) {
            // Bueltatzen duena json bat da gero front-ak irakurtzeko 
            return response()->json($emaitza);
        } else {
            $emaitza = [[
                    "id"=> "",
                    "id_langilea"=> "",
                    "id_materiala"=> "",
                    "hasiera_data"=> "",
                    "amaiera_data"=> ""
            ]];

            // Bueltatzen duena json bat da gero front-ak irakurtzeko 
            return response()->json($emaitza);
        }
    }

    // HAY QUE COMENTARLO

    public function reservarNuevo(){
    
        $emaitza = materiala_erabili::join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
            ->select(
                'materiala_erabili.id', 
                'materiala_erabili.id_langilea', 
                'materiala_erabili.id_materiala',  
                'materiala_erabili.amaiera_data',
                'materiala.etiketa', 
                'materiala.izena')
            ->orderByDesc('materiala_erabili.id')
            ->get();
    
        if ($emaitza->isNotEmpty()) {
            // Devuelve un JSON para que el frontend pueda leerlo
            return response()->json($emaitza);
        } else {
            $emaitza = [
                [
                    "id"=> "",
                    "id_langilea"=> "",
                    "id_materiala"=> "",
                    "amaiera_data"=> "",
                    "etiketa" => "",
                    "izena" => ""
                ]
            ];
    
            // Devuelve un JSON para que el frontend pueda leerlo
            return response()->json($emaitza);
        }
    }
    
    

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/devolver",
     *     tags={"Materiala"},
     *     summary="Materiala bueltatzeko funtzioa",
     *     @OA\Response(response="200", description="Materiala bueltatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id_materiala"},
     *                 @OA\Property(
     *                     property="id_materiala",
     *                     type="integer",
     *                     example="1",
     *                     description="Materialaren IDa"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    // Materiala bueltatzeko funtzioa, update bat egiten duena "amaiera_data"-n data bat jartzen jakitzeko noiz bueltatu den materiala. 
    public function devolver(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $ultimoRegistro = materiala_erabili::where('id_materiala', $datos["id_materiala"])
        // Asken "id"-a hartzeko 
        ->latest("id");

        if ($ultimoRegistro) {
            $ultimoRegistro->update(['amaiera_data' => $hoy]);
            return response()->json(['message' => 'Datuak aldatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak aldatu.'], 404);
        }
    }
    
    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/ezabatu",
     *     tags={"Materiala"},
     *     summary="Materiala ezabatzeko funtzioa",
     *     @OA\Response(response="200", description="Materiala ezabatu da."),
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
     *                     example="1",
     *                     description="Materialaren IDa"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    // Materiala ezabatzeko funtzioa, modu logikoan, ezabatze data jarrita, update bat bakarrik izanda
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $emaitza = materiala::where('materiala.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);

        if ($emaitza > 0) {
            return response("Materiala ezabatu da.", 200);
        } else {
            return response()->json(['message' => 'Ez da ezabatzeko materialik aurkitu.'], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/txertatu",
     *     tags={"Materiala"},
     *     summary="Material berria sartzeko funtzioa",
     *     @OA\Response(response="200", description="Materiala txertatu da."),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"etiketa", "izena"},
     *                 @OA\Property(
     *                     property="etiketa",
     *                     type="string",
     *                     example="SEC31",
     *                     description="Materialaren etiketa"
     *                 ),
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Secador",
     *                     description="Materialaren izena"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    // Material berria sartzeko funtzioa,insert bat "etiketa" eta "izena" hartzen dutenak
    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $id = materiala::insertGetId([
             'etiketa' =>  $datos["etiketa"],
             'izena' =>  $datos["izena"]
         ]);
         // Bueltatzen duena aldaketak izan dituen materialaren id-a da, gero front-ean kontuan izateko
         if ($id) {
            return response()->json(['id' => $id], 200);
        } else {
            return response()->json(['message' => 'Ezin izan da materiala txertatu.'], 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/grupos",
     *     tags={"Materiala"},
     *     summary="Erreserba egiterakoan zein talde dauden jakiteko",
     *     @OA\Response(response="200", description="Datuak lortu dira.")
     * )
     */
    // Erreserba egiterakoan zein talde dauden jakiteko Select bat, kontuan izanda "ezabatze_data" ez izatea null
    public function saberGrupo (){
        $emaitza = taldea::select(
            'kodea',
            'izena'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira talderik aurkitu.'], 400);
        }else{
            return json_encode($emaitza);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/alumnos/{kodea}",
     *     tags={"Materiala"},
     *     summary="Erreserba egiterakoan zein ikasle dauden jakiteko",
     *     @OA\Parameter(
     *         name="kodea",
     *         in="path",
     *         required=true,
     *         example="1",
     *         description="Taldearen kodea"
     *     ),
     *     @OA\Response(response="200", description="Datuak lortu dira.")
     * )
     */
    // Erreserba egiterakoan zein ikasle dauden jakiteko Select bat, kontuan izanda "ezabatze_data" ez izatea null
    public function saberAlumnos ($talde){
        $emaitza = langilea::select(
            'izena',
            'abizenak',
            'id'
        )
            ->where('kodea', $talde)
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 400);
        } else {
            return response()->json($emaitza);
        }
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/reservar",
     *     tags={"Materiala"},
     *     summary="Erreserba egiterakoan zein ikasle dauden jakiteko",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id_materiala", "id_langilea"},
     *                 @OA\Property(
     *                     property="id_materiala",
     *                     type="integer",
     *                     example="2",
     *                     description="Materialaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="id_langilea",
     *                     type="integer",
     *                     example="1",
     *                     description="Langilearen IDa"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Datuak lortu dira.")
     * )
     */
    // Materiala erreserbatzeko funtzioa, non insert bat egiten den kontuan izanda "id_materiala", "id_langilea", jarrita noiz izan den "hasiera_data"-n eta "amaiera_data" null jarrita
    public function reservarMaterial(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $id = materiala_erabili::insertGetId([
            'id_materiala' => $datos["id_materiala"],
            'id_langilea' => $datos["id_langilea"],
            'hasiera_data' => $hoy,
            'amaiera_data' => null
        ]);
        // Bueltatzen duena aldaketak izan dituen materialaren id-a da, gero front-ean kontuan izateko
        if ($id) {
            return response()->json(['id' => $id], 200);
        } else {
            return response()->json(['message' => 'Ezin izan da materiala erreserbatu.'], 400);
        }
    }
 
    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/materiala/editatu",
     *     tags={"Materiala"},
     *     summary="Materiala editatu ahal izateko funtzioa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "etiketa", "izena"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="2",
     *                     description="Materialaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="etiketa",
     *                     type="string",
     *                     example="SEC65",
     *                     description="Materialaren etiketa"
     *                 ),
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Secador",
     *                     description="Materialaren izena"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Materiala editatu da.")
     * )
     */
    // Materiala editatu ahal izateko funtzioa, update bat egiten duena kontuan izanda "materiala.id"
    public function editatu(Request $request){
         $datos = $request->json()->all();
         $hoy = date('Y-m-d H:i:s');
         
         $emaitza = materiala::where('materiala.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'etiketa' => $datos['etiketa'], 'izena' => $datos['izena']]);
        
         if ($emaitza) {
            return response()->json(['message' => 'Datuak aldatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak aldatu.'], 400);
        }
    }
}

