<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produktua;
use App\Models\kategoria;
use App\Models\produktu_mugimendua;

class Productos_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/productos",
     *     tags={"Produktuak"},
     *     summary="Produktuen datuak lortu",
     *     @OA\Response(response="200", description="Produktuen datuak lortu dira.")
     * )
     */
    // Produktuen datuak erakutsi
    public function erakutsi(){
        $emaitza = produktua::join('kategoria', 'kategoria.ID', '=', 'produktua.id_kategoria')
            ->select('produktua.id', 'produktua.izena', 'produktua.marka', 'produktua.id_kategoria', 'produktua.deskribapena', 'produktua.stock', 'produktua.stock_alerta', 'kategoria.izena as kategoria')
            ->whereNull('produktua.ezabatze_data') 
            ->orderBy('produktua.izena', 'asc')
            ->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/productos/mugimendua",
     *     tags={"Produktuak"},
     *     summary="Zenbat aldiz erabili den produktu bakoitza",
     *     @OA\Response(response="200", description="Produktuen datuak lortu dira.")
     * )
     */
    // Zenbat aldiz erabili den produktu bakoitza
    public function erakutsiMugimendua(){
        $emaitza = produktua::join('produktu_mugimendua', 'produktua.id', '=', 'produktu_mugimendua.id_produktua')
        ->groupBy('produktua.izena')
        ->select('produktua.izena', produktu_mugimendua::raw('SUM(produktu_mugimendua.kopurua) AS total_kopurua'))
        ->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/productos/mugimenduguztiak",
     *     tags={"Produktuak"},
     *     summary="Noiz erabili den produktu bakoitza",
     *     @OA\Response(response="200", description="Produktuen datuak lortu dira.")
     * )
     */
    // Noiz erabili den produktu bakoitza
    public function erakutsiMugimenduGuztiak(){
        $emaitza = produktu_mugimendua::join('produktua', 'produktu_mugimendua.id_produktua', '=', 'produktua.id')
        ->join('langilea', 'produktu_mugimendua.id_langilea', '=', 'langilea.id')
        ->select(
            produktu_mugimendua::raw('produktua.izena AS produktu_izena'), 
            'produktua.marka', 
            'langilea.izena', 
            'langilea.abizenak', 
            'produktu_mugimendua.data', 
            'produktu_mugimendua.kopurua')
        ->get();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }
    
    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/productos/ezabatu",
     *     tags={"Produktuak"},
     *     summary="Produktuak ezabatzeko metodoa",
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
     *                     description="Produktuaren IDa"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Produktuen datuak ezabatu dira.")
     * )
     */
    // Produktuak ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $emaitza = Produktua::where('produktua.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak ezabatu.'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/productos/editatu",
     *     tags={"Produktuak"},
     *     summary="Produktuak editateko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "izena", "marka", "kategoria", "deskribapena", "stock", "stock_alerta"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="2",
     *                     description="Produktuaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Laca",
     *                     description="Produktuaren izena"
     *                 ),
     *                 @OA\Property(
     *                     property="marka",
     *                     type="string",
     *                     example="LACAS SL",
     *                     description="Produktuaren marka"
     *                 ),
     *                 @OA\Property(
     *                     property="kategoria",
     *                     type="integer",
     *                     example="2",
     *                     description="Produktuaren kategoria IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="deskribapena",
     *                     type="string",
     *                     example="Laca para el pelo fino",
     *                     description="Produktuaren deskribapena"
     *                 ),
     *                 @OA\Property(
     *                     property="stock",
     *                     type="integer",
     *                     example="1",
     *                     description="Produktuaren stock-eko kantitatea"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_alerta",
     *                     type="integer",
     *                     example="10",
     *                     description="Stock alerta-ko kantitatea"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Produktuen datuak editatu dira.")
     * )
     */
    // Produktuak editateko metodoa
    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = Produktua::where('produktua.id', $datos["id"])
        ->update([
            'eguneratze_data' => $hoy, 
            'izena' => $datos['izena'], 
            'marka' => $datos['marka'],
            'id_kategoria' => $datos['kategoria'],
            'deskribapena' => $datos['deskribapena'], 
            'stock' => $datos['stock'],
            'stock_alerta' => $datos['stock_alerta']
        ]);

        if ($emaitza > 0) {
            return response('Datuak editatu dira.', 200);
        } else {
            return response('Ezin izan dira datuak editatu.', 404);
        }
    } 

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/productos/txertatu",
     *     tags={"Produktuak"},
     *     summary="Produktuak txertatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"izena", "marka", "kategoria", "deskribapena", "stock", "stock_alerta"},
     *                 @OA\Property(
     *                     property="izena",
     *                     type="string",
     *                     example="Champu",
     *                     description="Produktuaren izena"
     *                 ),
     *                 @OA\Property(
     *                     property="marka",
     *                     type="string",
     *                     example="Loreal",
     *                     description="Produktuaren marka"
     *                 ),
     *                 @OA\Property(
     *                     property="kategoria",
     *                     type="integer",
     *                     example="1",
     *                     description="Produktuaren kategoria IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="deskribapena",
     *                     type="string",
     *                     example="Hidratante",
     *                     description="Produktuaren deskribapena"
     *                 ),
     *                 @OA\Property(
     *                     property="stock",
     *                     type="integer",
     *                     example="5",
     *                     description="Produktuaren stock-eko kantitatea"
     *                 ),
     *                 @OA\Property(
     *                     property="stock_alerta",
     *                     type="integer",
     *                     example="10",
     *                     description="Stock alerta-ko kantitatea"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Produktuen datuak txertatu dira.")
     * )
     */
    // Produktuak txertatzeko metodoa
    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $id = produktua::insertGetId([
            'eguneratze_data' => $hoy,  
            'izena' => $datos['izena'], 
            'marka' => $datos['marka'],
            'id_kategoria' => $datos['kategoria'],
            'deskribapena' => $datos['deskribapena'], 
            'stock' => $datos['stock'],
            'stock_alerta' => $datos['stock_alerta']
        ]);

        if ($id) {
            return response()->json(['message' => 'Datuak txertatu dira.', 'id' => $id], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak txertatu.'], 400);
        }
    }

    /**
     * @OA\Post(
     *     path="/talde2erronka2back/Erronka2/public/api/productos/erosi",
     *     tags={"Produktuak"},
     *     summary="Produktuak erosteko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id_produktua", "kopurua", "id_langilea"},
     *                 @OA\Property(
     *                     property="id_produktua",
     *                     type="integer",
     *                     example="3",
     *                     description="Erosi nahi den produktuaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="kopurua",
     *                     type="integer",
     *                     example="1",
     *                     description="Erosi nahi den produktuaren kantitatea"
     *                 ),
     *                 @OA\Property(
     *                     property="id_langilea",
     *                     type="integer",
     *                     example="1",
     *                     description="langilearen IDa"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Produktuen datuak txertatu dira.")
     * )
     */
    //Probar///////////////////////////////////////////////////////
    public function mugimenduBerria(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        try {
            Produktua::where('produktua.id', $datos["id_produktua"])
            ->update([
                'eguneratze_data' => $hoy, 
                'stock' => Produktua::raw('stock - ' . $datos['kopurua'])
            ]);
        } catch (\Throwable $th) {
            return response('Error al bajar el stock del producto: '.$datos["id_produktua"], 500);
        }

        try{
            
            produktu_mugimendua::insert([
                'id_produktua' => $datos['id_produktua'],
                'id_langilea' => $datos['id_langilea'],
                'data' => $hoy,
                'kopurua' => $datos['kopurua']
            ]);
            
            return response('All OK', 200);
        }catch(\Throwable $th){
            return response('error al insertar movimiento del producto: '.$datos["id_produktua"], 500);
        }
        
    }


}
