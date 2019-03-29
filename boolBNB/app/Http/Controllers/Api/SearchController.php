<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Apartment;

class SearchController extends Controller
{
  public function getApartmentsByCity(Request $request){

    //estraiamo i dati dal JSON dalla request
    parse_str($request->getContent(), $data);
    // dd($data);
    //leggiamo la chiave isAdvanced per decidere
    //il tipo di output
    // if ($data['isAdvanced'] === 'true') {
    //     $filteredApartments = Apartment::where('optional_id', '=', $data->optionals[0]);
    //     return response()->json($data);
    // } else {
    // return response()->json($data);
        $risultati = [];

        $allApartments = Apartment::all();
        // dd($allApartments);
        foreach ($allApartments as $apartment) {

            $lat = deg2rad($apartment->latitude - $data['lat']);
          	$long = deg2rad($apartment->longitude - $data['lon']);

          	$a = sin($lat/2) * sin($lat/2) + cos(deg2rad($data['lat'])) * cos(deg2rad($apartment->latitude)) * sin($long/2) * sin($long/2);
          	$c = 2 * atan2(sqrt($a), sqrt(1 - $a));
          	$distance = 6371 * $c;
            // return response()->json(['distance' => $distance, 'address' => $apartment->address]);
            if($distance < $data['radius']){
              $risultati[] = $apartment;
            }
        }



        if ($data['isAdvanced'] === 'true'){

          dd($data['optionals']);

          }
          //$filteredOptionals = Optional::where('optional_id', '=', $data->optionals[0]);


          return response()->json(['error' => ' ']);
        }
        //
        // dd($data);


        return response()->json($data->all::(optionals);
    // }

  }
}
