<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produktua;
use App\Models\kategoria;
use App\Models\produktu_mugimendua;

class Productos_Controller extends Controller
{
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



}
        if ($id) {
            return response()->json(['message' => 'Datuak txertatu dira.', 'id' => $id], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak txertatu.'], 400);
        }
    }
}
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
