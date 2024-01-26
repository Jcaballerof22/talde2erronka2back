<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\txanda;
use App\Models\langilea;
use App\Models\taldea;

class Roles_Controller extends Controller
{
    public function txandaHistorial(){
        $resultado = txanda::join('langilea', 'txanda.id_langilea', '=', 'langilea.id')
        ->select('txanda.mota', 'txanda.data', 'langilea.izena')
        ->orderByDesc('txanda.data')
        ->get();

        return json_encode($resultado);
    }
    
    public function erakutsi($taldea){

        $id = taldea::where('izena', $taldea)->pluck('kodea');

        $emaitza = langilea::join('txanda', 'langilea.id', '=', 'txanda.id_langilea')
        ->select('langilea.izena', 'langilea.abizenak', 'txanda.id_langilea',
                langilea::raw('SUM(CASE WHEN txanda.mota = "M" THEN 1 ELSE 0 END) AS suma_m'),
                langilea::raw('SUM(CASE WHEN txanda.mota = "G" THEN 1 ELSE 0 END) AS suma_g'))
        ->where('langilea.kodea', '=', $id)
        ->groupBy('txanda.id_langilea', 'langilea.izena', 'langilea.abizenak')
        ->get();

        return json_encode($emaitza);
    }

    public function erakutsiPertsonak($taldea){

        $id = taldea::where('izena', $taldea)->pluck('kodea');

        $emaitza = langilea::join('txanda', 'langilea.id', '=', 'txanda.id_langilea')
        ->select('langilea.izena', 'langilea.abizenak', 'txanda.id_langilea', 'txanda.data', 'txanda.mota', 'txanda.ezabatze_data',
                langilea::raw('SUM(CASE WHEN txanda.mota = "M" THEN 1 ELSE 0 END) AS suma_m'),
                langilea::raw('SUM(CASE WHEN txanda.mota = "G" THEN 1 ELSE 0 END) AS suma_g'))
        ->where('langilea.kodea', '=', $id)
        ->groupBy('txanda.id_langilea', 'langilea.izena', 'langilea.abizenak', 'txanda.data', 'txanda.mota', 'txanda.ezabatze_data')
        ->get();

        return json_encode($emaitza);
    }

    

    public function ezabatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        txanda::where('id_langilea', $datos["id_langilea"])
        ->where('data', $hoy)
        ->update(['ezabatze_data' => $hoy]);

        return response()->json(['message' => 'Operación exitosa']);
    }

    public function txertatu(Request $request){
        $datos = $request->json()->all();

        $hoy = date('Y-m-d');

        txanda::insert([
            'data' => $hoy,
            'eguneratze_data' => $hoy,
            'id_langilea' => $datos["id_langilea"],
            'mota' => $datos["mota"],
            'sortze_data' => $hoy
        ]);
        return response()->json(['message' => 'Operación exitosa']);
    }
}
