<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Apartment;

class SearchController extends Controller
{
  public function getApartmentsByCity(Request $request){

    //estraiamo i dati dal JSON dalla request
    parse_str($request->getContent(),$data);

    //leggiamo la chiave isAdvanced per decidere
    //il tipo di output
    if ($data['isAdvanced'] === 'true') {
        $filteredApartments = Apartment::where('optional_id', '=', $data->optionals[0]);
        return response()->json($data);
    } else {
        return response()->json(Apartment::all());
    }

  }
}
