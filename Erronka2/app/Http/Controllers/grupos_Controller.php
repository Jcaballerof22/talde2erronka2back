<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\erabiltzailea;
use App\Models\taldea;

class grupos_Controller extends Controller
{
    //
    public function erakutsi() {
        $emaitza=taldea::all();
        return $emaitza;
    }


}
