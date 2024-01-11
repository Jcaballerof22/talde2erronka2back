<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taldea;
use App\Models\ordutegia;

class Ordutegia_Controller extends Controller
{
    public function erakutsi() {
        $emaitza = ordutegia::select('ordutegia.EGUNA', 'taldea.IZENA')
        ->join('taldea', 'ordutegia.KODEA', '=', 'taldea.KODEA')
        ->get();
    
        return json_encode($emaitza);
    }

    public function editatu(Request $request){
        $datos = $request->all();

        $izena = $datos["izena"];
        $eguna = $datos["eguna"];
        
        switch ($datos["eguna"]) {
            case 'Lunes':
                $eguna = 1;
                break;
            case 'Martes':
                $eguna = 2;
                break;
            case 'Miércoles':
                $eguna = 3;
                break;
            case 'Jueves':
                $eguna = 4;
                break;
            case 'Viernes':
                $eguna = 5;
                break;
            default:
                # code...
                break;
        }

        $taldeaKodea = taldea::where('izena', $izena)->value('kodea');

        ordutegia::where('eguna', $eguna)
            ->update(['kodea' => $taldeaKodea]);

        return "BIen";
    }
}

