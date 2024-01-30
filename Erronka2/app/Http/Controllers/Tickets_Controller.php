<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ticket_lerroa;

class Tickets_Controller extends Controller
{
    public function erakutsi(){
        $emaitza = ticket_lerroa::join('hitzordua', 'ticket_lerroa.id_hitzordua', '=', 'hitzordua.id')
        ->join('tratamendua', 'ticket_lerroa.id_tratamendua', '=', 'tratamendua.id')
        ->select('hitzordua.izena', 'hitzordua.data', 'tratamendua.izena', 'ticket_lerroa.prezioa')
        ->get();
        return json_encode($emaitza);

    }
}
