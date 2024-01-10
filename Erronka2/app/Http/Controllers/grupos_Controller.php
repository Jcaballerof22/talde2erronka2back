<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\erabiltzailea;
use App\Models\langilea;
use App\Models\taldea;

class grupos_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = taldea::select('taldea.izena', langilea::raw('COUNT(langilea.kodea) as langileak'))
        ->join('langilea', 'taldea.kodea', '=', 'langilea.kodea')
        ->groupBy('taldea.izena')
        ->get();
        // $emaitza=taldea::all();
        return json_encode($emaitza);
    }


}
