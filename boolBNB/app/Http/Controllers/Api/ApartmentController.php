<?php

namespace App\Http\Controllers\Api;

use App\Apartment;
use App\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApartmentController extends Controller
{


    public function updateNrOfViews(Request $request)
    {

      //estraiamo i dati dal JSON dalla request
      parse_str($request->getContent(), $data);

      if(!empty($data['apartment_id'])){

        $apartmentToUpdate = Apartment::find($data['apartment_id']);

        if ($apartmentToUpdate->user_id != $data['user_id']){
          $apartmentToUpdate->views = $apartmentToUpdate['views'] + 1;

          $apartmentToUpdate->save();

          $newViewPerApartment = new View;

          $newViewPerApartment->apartment_id = $data['apartment_id'];

          $newViewPerApartment->save();

          return response()->json([
            'status' => 'success',
            'message' => 'views update successful',
          ]);
        }

        return response()->json([
          'status' => 'success',
          'message' => 'you are the owner, nothing to update',
        ]);


      } else {

        return response()->json([
            'status' => 'error',
            'message' => 'No Apartment id'
          ]);
      }


    }

    public function getNrOfViews(Request $request)
    {
      //estraiamo i dati dal JSON dalla request
      parse_str($request->getContent(), $data);

      if(!empty($data['apartment_id'])){

        $apartmentToUpdate = Apartment::find($data['apartment_id']);

        $apartmentToUpdate->views = $apartmentToUpdate['views'] + 1;

        $apartmentToUpdate->save();

        return response()->json([
          'status' => 'success',
          'message' => 'views update succesful',
        ]);
      } else {

        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred!'
          ]);
      }


    }


}
