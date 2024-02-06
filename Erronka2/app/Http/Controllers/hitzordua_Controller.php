<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hitzordua;
class hitzordua_Controller extends Controller
{
    //
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


}