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
}

