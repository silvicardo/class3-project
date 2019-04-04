<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;
use App\User;
use App\Apartment;
use App\Subscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller

{

    //middleware permessi sul costruttore
    public function __construct(){


      //1.se non sei loggato puoi accedere solo ad index e a show
      $this->middleware('auth'); //NON PASSATO? REGISTER O LOGIN

      //tutti gli user registrati hanno permesso di
      //gestire la propria messaggistica,
      //esplicitiamo comunque questa possibilità
      $this->middleware('permission:manage-owner');

      //In caso non si soddisfino le proprietà si riviene
      //mandati alla pagina 403:forbidden

    }


    public function create(Apartment $apartment = null)
    {
        return view('admin.owner.sponsor',
        [
          'owner' => Auth::user(),
          'plans' =>  Plan::all(),
          'selectedApartment' => $apartment
        ]);
    }


    public function store(Request $request)
    {
         // Recupero il piano
          $plan = Plan::findOrFail($request->plan_id);


          if(!Auth::user()->subscribedToPlan($plan->braintree_plan, $request->apartment_id)){

            // subscribe the user
            $request->user()->newSubscription($request->apartment_id, $plan->braintree_plan)->create($request->payment_method_nonce);

            $last = Subscription::all()->last();

            $last->apartment()->associate($request->apartment_id);

             $last->save();

            // redirect to home after a successful subscription
            return redirect()->route('owner.show');

          } else {

            return redirect()->route('owner.show', ['error' => 'Hai già sottoscritto un piano per questo appartamento']);
          }




    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
