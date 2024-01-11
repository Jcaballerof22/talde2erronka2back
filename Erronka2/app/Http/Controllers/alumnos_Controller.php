<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taldea;
use App\Models\langilea;

class alumnos_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza = langilea::select('langilea.izena', langilea::raw('COUNT(langilea.kodea) as langileak'))
        ->Leftjoin('langilea', 'taldea.kodea', '=', 'langilea.kodea')
        ->whereNull('taldea.ezabatze_data')
        ->groupBy('langilea.izena')
        ->orderBy('langileak', 'desc')
        ->get();
        return json_encode($emaitza);
    }
}
