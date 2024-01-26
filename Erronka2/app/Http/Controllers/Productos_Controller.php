<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\produktua;
use App\Models\kategoria;
use App\Models\produktu_mugimendua;

class Productos_Controller extends Controller
{
    //
    public function erakutsi(){
        $emaitza = Produktua::join('kategoria', 'kategoria.ID', '=', 'produktua.id_kategoria')
            ->select('produktua.id', 'produktua.izena', 'produktua.marka', 'produktua.deskribapena', 'produktua.stock', 'kategoria.izena as kategoria')
            ->whereNull('produktua.ezabatze_data') 
            ->orderBy('produktua.izena', 'asc')
            ->get();
        return json_encode($emaitza);
    }

    public function erakutsiMugimendua(){
        $emaitza = produktua::join('produktu_mugimendua', 'produktua.id', '=', 'produktu_mugimendua.id_produktua')
        ->groupBy('produktua.izena')
        ->select('produktua.izena', produktu_mugimendua::raw('SUM(produktu_mugimendua.kopurua) AS total_kopurua'))
        ->get();
        return json_encode($emaitza);
    }
    
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        Produktua::where('produktua.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        return "allOk";
    }

    public function editatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');

        $kategoria = Kategoria::where('izena', $datos["kategoria"])->value('id');

        Produktua::where('produktua.id', $datos["id"])
        ->update([
            'eguneratze_data' => $hoy, 
            'id' => $datos['id'], 
            'izena' => $datos['izena'], 
            'marka' => $datos['marka'],
            'id_kategoria' => $kategoria,
            'deskribapena' => $datos['deskribapena'], 
            'stock' => $datos['stock']
        ]);
        return "allOkk";
   } 




}
