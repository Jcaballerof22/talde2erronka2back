<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoria;

class Categorias_Controller extends Controller
{
    //
    public function erakutsi(){
        $emaitza = Kategoria::all();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira kategoriarik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }
    
}
