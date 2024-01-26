<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hitzordua;
use App\Models\tratamendua;

class hitzordua_Controller extends Controller
{
    //
    public function erakutsi($fecha) {
        $simbol = '=';
        if (strpos($fecha, "+")){
            $fecha = str_replace("+", "", $fecha);
            $simbol = '>=';
        }

        $emaitza = hitzordua::select()
            ->whereNull('ezabatze_data')
            ->where('data', $simbol, $fecha)
            ->orderBy('hasiera_ordua', 'asc')
            ->get();
        return json_encode($emaitza);
    }

    public function tratamenduak(){
        $emaitza = tratamendua::select()
            ->whereNull('ezabatze_data')
            ->get();
        return json_encode($emaitza);
    }

}