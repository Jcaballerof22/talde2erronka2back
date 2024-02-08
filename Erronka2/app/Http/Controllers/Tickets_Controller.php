<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ticket_lerroa;

class Tickets_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/tickets",
     *     tags={"Tickets"},
     *     summary="Ticket guztien datuak lortzeko metodoa",
     *     @OA\Response(response="200", description="Ticketen datuak lortu dira.")
     * )
     */
    // Ticket guztien datuak lortzeko metodoa
    public function erakutsi(){
        $emaitza = ticket_lerroa::join('hitzordua', 'ticket_lerroa.id_hitzordua', '=', 'hitzordua.id')
        ->join('tratamendua', 'ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
        ->whereNull('ticket_lerroa.ezabatze_data')
        ->select('hitzordua.izena AS bezero_izena', 'hitzordua.data', 'tratamendua.izena AS tratamendu_izena', 'ticket_lerroa.prezioa', 'ticket_lerroa.id')
        ->get();
        
        if ($emaitza->isNotEmpty()) {
            return response()->json($emaitza, 200);
        } else {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        }
    }

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/tickets/editatu",
     *     tags={"Tickets"},
     *     summary="Ticketa editatzeko metodoa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 required={"id", "id_tratamendua", "prezioa"},
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",
     *                     example="1",
     *                     description="Ticketaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="id_tratamendua",
     *                     type="integer",
     *                     example="1",
     *                     description="Tratamenduaren IDa"
     *                 ),
     *                 @OA\Property(
     *                     property="prezioa",
     *                     type="number",
     *                     format="float",
     *                     example="25.50",
     *                     description="Ticketaren prezioa"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ticketen datuak editatu dira.")
     * )
     */
    // Ticketa editatzeko metodoa
    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $emaitza = ticket_lerroa::where('id', $datos['id'])->update(['id_tratamendua' => $datos['id_tratamendua'], 'prezioa' => $datos['prezioa'], 'eguneratze_data' => $hoy]);
        
        if ($emaitza) {
            return response('Datuak editatu dira.', 200);
        } else {
            return response('Ezin izan dira datuak aldatu.', 400);
        }
    } 

    /**
     * @OA\Put(
     *     path="/talde2erronka2back/Erronka2/public/api/tickets/ezabatu",
     *     tags={"Tickets"},
     *     summary="Ticketa ezabatzeko metodoa",
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
     *                     description="Ticketa IDa"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Ticketen datuak ezabatu dira.")
     * )
     */
    // Ticketa ezabatzeko metodoa
    public function ezabatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        $emaitza = ticket_lerroa::where('id', $datos["id"])
        ->update(['ezabatze_data' => $hoy]);

        if ($emaitza) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak ezabatu.'], 400);
        }
    }
}
