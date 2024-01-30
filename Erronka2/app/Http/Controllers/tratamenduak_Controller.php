<?php

namespace App\Http\Controllers;

use App\Models\ticket_lerroa;
use Illuminate\Http\Request;
use App\Models\tratamendua;


class tratamenduak_Controller extends Controller
{
    //
    public function erakutsi(){
        $emaitza = tratamendua::select()
            ->whereNull('ezabatze_data')
            ->get();
        return json_encode($emaitza);
    }

    public function hitzorduTratamendu($hitzorduaId){
        $emaitza = ticket_lerroa::select('ticket_lerroa.*', tratamendua::raw('tratamendua.izena as tratamenduIzena'))
            ->Leftjoin('tratamendua', 'ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
            ->whereNull('ticket_lerroa.ezabatze_data')
            ->where('ticket_lerroa.id_hitzordua',$hitzorduaId)
            ->get();
        return json_encode($emaitza);
    }

    public function addhitzorduTratamendu(Request $request){
        $datos = $request->json()->all();
        $id = ticket_lerroa::insertGetId([
             'id_hitzordua' =>  $datos["id_hitzordua"],
             'id_tratamendua' =>  $datos["id_tratamendua"],
             'prezioa' => $datos["prezioa"]
             // ... otras columnas y valores
         ]);
         return $id;
    }

    public function removehitzorduTratamendu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        ticket_lerroa::where('id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        return json_encode("allOk");
    }

}
