<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\txanda;
use App\Models\langilea;
use App\Models\taldea;

class Roles_Controller extends Controller
{
    public function erakutsi($taldea){

        $id = taldea::where('izena', $taldea)->pluck('kodea');

        $emaitza = langilea::join('txanda', 'langilea.id', '=', 'txanda.id_langilea')
        ->select('langilea.izena', 'langilea.abizenak', 'txanda.id_langilea', 'txanda.data', 'txanda.ezabatze_data', 'txanda.mota',
                langilea::raw('SUM(CASE WHEN txanda.mota = "M" THEN 1 ELSE 0 END) AS suma_m'),
                langilea::raw('SUM(CASE WHEN txanda.mota = "G" THEN 1 ELSE 0 END) AS suma_g'))
        ->where('langilea.kodea', '=', $id)
        ->groupBy('txanda.id_langilea', 'langilea.izena', 'langilea.abizenak', 'txanda.data', 'txanda.ezabatze_data', 'txanda.mota')
        ->get();

        return json_encode($emaitza);
    }
}
