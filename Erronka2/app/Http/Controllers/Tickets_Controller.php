<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ticket_lerroa;

class Tickets_Controller extends Controller
{
    public function erakutsi(){
        $emaitza = ticket_lerroa::join('hitzordua', 'ticket_lerroa.id_hitzordua', '=', 'hitzordua.id')
        ->join('tratamendua', 'ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
        ->whereNull('ticket_lerroa.ezabatze_data')
        ->select('hitzordua.izena AS bezero_izena', 'hitzordua.data', 'tratamendua.izena AS tratamendu_izena', 'ticket_lerroa.prezioa', 'ticket_lerroa.id')
        ->get();
        return json_encode($emaitza);
    }

    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        ticket_lerroa::where('id', $datos['id'])->update(['id_tratamendua' => $datos['id_tratamendua'], 'prezioa' => $datos['prezioa'], 'eguneratze_data' => $hoy]);
        return "allOkk";
    } 

    public function ezabatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        ticket_lerroa::where('id', $datos["id"])
        ->update(['ezabatze_data' => $hoy]);

        return response()->json(['message' => 'Operación exitosa']);
    }
}
