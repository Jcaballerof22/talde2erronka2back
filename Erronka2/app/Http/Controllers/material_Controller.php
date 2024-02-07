<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\materiala;
use App\Models\materiala_erabili;
use App\Models\langilea;
use App\Models\taldea;

class material_Controller extends Controller
{
    //
    //Taulan erakusteko datuak lortzen dituen Select-a, kontuan izanda "ezabatze_data" = null bada ez agertzea, ezabaketa logikoa
    public function erakutsi() {
        $emaitza = materiala::select(
            'etiketa',
            'izena',
            'id'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
        
        // Bueltatzen duena json bat da gero front-ak irakurtzeko  
        if ($emaitza->isEmpty()) {
            return response()->json(['message' => 'Ez dira daturik aurkitu.'], 404);
        } else {
            return response()->json($emaitza, 200);
        }
    }

    // Kontuan izateko zenbat bider erabili diren materialak historialean, Select bat Count batekin
    public function erakutsiErabili() {
        $emaitza = materiala::join('materiala_erabili', 'materiala.id', '=', 'materiala_erabili.id_materiala')
        ->groupBy('materiala.izena', 'materiala.etiketa')
        ->select('materiala.izena', 'materiala.etiketa', materiala_erabili::raw('COUNT(materiala_erabili.id) as count_id'))
        ->get();

        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        return json_encode($emaitza);
    }

    // Kontuan izateko materiala nork izan duen eta beraien mugimenduak historialean, Select bat erabilita
    public function erakutsiMugimenduak(){
        $emaitza = materiala_erabili::join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
        ->join('langilea', 'materiala_erabili.id_langilea', '=', 'langilea.id')
        ->select('materiala.izena AS materiala', 'langilea.izena', 'langilea.abizenak', 'materiala_erabili.hasiera_data', 'materiala_erabili.amaiera_data')
        ->get();

        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        return json_encode($emaitza);
    }

    // Jakin ahal izateko material bat libre edo okupaturik dagoen, ez bada inoiz erreserbatu, hutsik bueltatuko du fron-era, Select bat baldintza desberdinekin eta bakarrik erregistro bat hartzen duena, id handiena duena
    public function reservar($id){
    
        $emaitza = langilea::join('materiala_erabili', 'langilea.id', '=', 'materiala_erabili.id_langilea')
            ->join('materiala', 'materiala_erabili.id_materiala', '=', 'materiala.id')
            ->select('materiala_erabili.id', 'materiala_erabili.id_langilea', 'materiala_erabili.id_materiala', 'materiala_erabili.hasiera_data', 'materiala_erabili.amaiera_data')
            ->where('materiala_erabili.id_materiala', $id)
            ->orderByDesc('materiala_erabili.id')
            ->limit(1)
            ->get();
    
        if ($emaitza->isNotEmpty()) {
            // Bueltatzen duena json bat da gero front-ak irakurtzeko 
            return response()->json($emaitza);
        } else {
            $emaitza = [[
                    "id"=> "",
                    "id_langilea"=> "",
                    "id_materiala"=> "",
                    "hasiera_data"=> "",
                    "amaiera_data"=> ""
            ]];

            // Bueltatzen duena json bat da gero front-ak irakurtzeko 
            return response()->json($emaitza);
        }
    }

    // Materiala bueltatzeko funtzioa, update bat egiten duena "amaiera_data"-n data bat jartzen jakitzeko noiz bueltatu den materiala. 
    public function devolver(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $ultimoRegistro = materiala_erabili::where('id_materiala', $datos["id_materiala"])
        // Asken "id"-a hartzeko 
        ->latest("id");

        if ($ultimoRegistro) {
            $ultimoRegistro->update(['amaiera_data' => $hoy]);
            return "allOk";
        } else {
            return "ERROR";
        }
    }
    
    // Materiala ezabatzeko funtzioa, modu logikoan, ezabatze data jarrita, update bat bakarrik izanda
    public function ezabatu(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        materiala::where('materiala.id', $datos["id"])->update(['ezabatze_data' => $hoy, 'eguneratze_data' => $hoy]);
        return "allOk";
    }

    // Material berria sartzeko funtzioa,insert bat "etiketa" eta "izena" hartzen dutenak
    public function txertatu(Request $request){
        $datos = $request->json()->all();
        $id = materiala::insertGetId([
             'etiketa' =>  $datos["etiketa"],
             'izena' =>  $datos["izena"]
         ]);
         // Bueltatzen duena aldaketak izan dituen materialaren id-a da, gero front-ean kontuan izateko
         return $id;
    }

    // Erreserba egiterakoan zein talde dauden jakiteko Select bat, kontuan izanda "ezabatze_data" ez izatea null
    public function saberGrupo (){
        $emaitza = taldea::select(
            'kodea',
            'izena'
        )
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        return json_encode($emaitza);
    }

    // Erreserba egiterakoan zein ikasle dauden jakiteko Select bat, kontuan izanda "ezabatze_data" ez izatea null
    public function saberAlumnos ($talde){
        $emaitza = langilea::select(
            'izena',
            'abizenak',
            'id'
        )
            ->where('kodea', $talde)
            ->whereNull('ezabatze_data')
            ->orderBy('izena', 'asc')
            ->get();
    
        // Bueltatzen duena json bat da gero front-ak irakurtzeko 
        return json_encode($emaitza);
    }

    // Materiala erreserbatzeko funtzioa, non insert bat egiten den kontuan izanda "id_materiala", "id_langilea", jarrita noiz izan den "hasiera_data"-n eta "amaiera_data" null jarrita
    public function reservarMaterial(Request $request){
        $datos = $request->json()->all();
        $hoy = date('Y-m-d H:i:s');
        $id = materiala_erabili::insertGetId([
            'id_materiala' => $datos["id_materiala"],
            'id_langilea' => $datos["id_langilea"],
            'hasiera_data' => $hoy,
            'amaiera_data' => null
        ]);
        // Bueltatzen duena aldaketak izan dituen materialaren id-a da, gero front-ean kontuan izateko
        return $id;
    }
 
    // Materiala editatu ahal izateko funtzioa, update bat egiten duena kontuan izanda "materiala.id"
    public function editatu(Request $request){
         $datos = $request->json()->all();
         $hoy = date('Y-m-d H:i:s');
         materiala::where('materiala.id', $datos["id"])->update(['eguneratze_data' => $hoy, 'etiketa' => $datos['etiketa'], 'izena' => $datos['izena']]);
         return "allOkk";
    }
}

