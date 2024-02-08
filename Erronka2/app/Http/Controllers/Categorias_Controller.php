<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kategoria;

class Categorias_Controller extends Controller
{
    /**
     * @OA\Get(
     *     path="/talde2erronka2back/Erronka2/public/api/kategoria",
     *     tags={"Kategoriak"},
     *     summary="Kategorien datuak lortu",
     *     @OA\Response(response="200", description="Datuak lortu dira.")
     * )
     */
    public function erakutsi(){
        $emaitza = Kategoria::all();

        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira kategoriarik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }
    
}
