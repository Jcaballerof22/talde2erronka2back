<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ticket_lerroa;
use App\Models\hitzordua;
use App\Models\tratamendua;

class tickets_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = hitzordua::select(
                'hitzordua.izena as nombre_tabla',
                'otra_tabla.fecha_guardado'
            )
            ->join('ticket_lerroa', 'Langilea.id', '=', 'ticket_lerroa.id_hitzordua')
            ->whereNull('Langilea.ezabatze_data')
            ->orderBy('hitzordua.izena', 'asc')
            ->get();
    
        return response()->json($emaitza);
    }
    
}
