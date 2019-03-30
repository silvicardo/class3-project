<?php

namespace App\Http\Controllers\Api;
use Carbon\Carbon;
use App\Apartment;
use App\View;
use App\User;
use App\Message;
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

    public function apartmentStats(Request $request)
    {
      //estraiamo i dati dal JSON dalla request
      parse_str($request->getContent(), $data);
      // !$request->hasHeader('Authorization')

      //VEDIAMO SE MI HAI DATO TUTTI I DATI NECESSARI PER PROCEDERE
      // if(!empty($data['user_id']) && !empty($data['apartment_id'])){
      if($request->hasHeader('apartment_id') && $request->hasHeader('user_id')){

        $apartment = Apartment::find($request->header('apartment_id'));

        //VEDIAMO SE SEI IL PROPRIETARIO
        if($request->header('user_id') == $apartment->user_id){

          //VEDIAMO SE HAI TROVATO UN APPARTAMENTO CON L ID RICHIESTO
          if($apartment !== null){

            //logica recupero dati

            $views =  View::get()->groupBy(function($d) {

                             return Carbon::parse($d->created_at)->format('F');
                         });
            $messages =  Message::get()->groupBy(function($d) {

                             return Carbon::parse($d->created_at)->format('F');
                         });



          return response()->json([
                              'views' => [
                                  'anni'=> [
                                          'nr_anno' => '2019',
                                          'mesi' =>  $views
                                            ]
                                          ],

                              'messaggi' => [
                                  'anni'=> [
                                          'nr_anno' => '2019',
                                          'messaggi' =>  $messages
                                            ]
                                          ]
                                        ]
                                      );



            return response()->json([
              'status' => 'success',
              'message' => 'dati per chart restituiti',
            ]);

          }

            return response()->json([
              'status' => 'error',
              'message' => 'Nessun Appartamento con questo id',
            ]);

          }

        //se non sono il proprietario
        return response()->json([
          'status' => 'error',
          'message' => 'non sei il proprietario, no dati',
        ]);
      } else {

        //DATI MANCANTI
        return response()->json([
            'status' => 'error',
            'message' => 'Dati insufficienti'
          ]);
      }


    }


}
