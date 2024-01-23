<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hitzordua;

class hitzordua_Controller extends Controller
{
    //
    public function erakutsi($fecha) {
        $emaitza = hitzordua::select()
            ->whereNull('ezabatze_data')
            ->where('data', '=', $fecha)
            ->orderBy('hasiera_ordua', 'asc')
            ->get();
        return json_encode($emaitza);
    }
}
