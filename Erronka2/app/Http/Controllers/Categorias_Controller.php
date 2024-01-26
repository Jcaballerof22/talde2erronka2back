<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoria;

class Categorias_Controller extends Controller
{
    //
    public function erakutsi(){
        $emaitza = Kategoria::select('izena')
        ->get();
        return json_encode($emaitza);
    }
    

}
