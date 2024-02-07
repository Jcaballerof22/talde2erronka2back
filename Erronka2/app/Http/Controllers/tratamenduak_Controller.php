<?php

namespace App\Http\Controllers;

use App\Models\ticket_lerroa;
use Illuminate\Http\Request;
use App\Models\tratamendua;


class tratamenduak_Controller extends Controller
{
    //Tratamenduen datuak lortzeko
    public function erakutsi(){
        $emaitza = tratamendua::select()
            ->whereNull('ezabatze_data')
            ->get();
        
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik lortu.'], 404);
        } else {
            return json_encode($emaitza);
        }
    }

    // Hitzordu baten tratamenduak lortzeko metodoa
    public function hitzorduTratamendu($hitzorduaId){
        $emaitza = ticket_lerroa::select('ticket_lerroa.*', tratamendua::raw('tratamendua.izena as tratamenduIzena'))
            ->Leftjoin('tratamendua', 'ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
            ->whereNull('ticket_lerroa.ezabatze_data')
            ->where('ticket_lerroa.id_hitzordua',$hitzorduaId)
            ->get();
        
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira tratamendurik aurkitu.'], 404);
        } else {
            return json_encode($emaitza);
        }
    }

    // Hitzordu bati tratamenduak txertatzeko metodoa
    public function addhitzorduTratamendu(Request $request){
        $datos = $request->json()->all();

        if (!isset($datos["id_hitzordua"]) || !isset($datos["id_tratamendua"]) || !isset($datos["prezioa"])) {
            return response()->json(['message' => 'Datuak falta dira.'], 400);
        }

        $id = ticket_lerroa::insertGetId([
             'id_hitzordua' =>  $datos["id_hitzordua"],
             'id_tratamendua' =>  $datos["id_tratamendua"],
             'prezioa' => $datos["prezioa"]
             // ... otras columnas y valores
         ]);

         return response()->json(['message' => 'Datuak txertatu dira.', 'id' => $id], 200);
    }

    // Hitzordu batetik tratamenduak kentzeko metodoa
    public function removehitzorduTratamendu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        
        $emaitza = ticket_lerroa::where('id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        
        if ($emaitza > 0) {
            return response()->json(['message' => 'Datuak ezabatu dira.'], 200);
        } else {
            return response()->json(['message' => 'Ezin izan dira datuak ezabatu.'], 404);
        }
    }

}
