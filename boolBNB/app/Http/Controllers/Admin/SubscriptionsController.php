<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Plan;
use App\User;
use App\Apartment;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{
    //variabile per conservare l'utente
    // che passa sul controller
    //e il suo ruolo
    protected $currentUser;

    //middleware permessi sul costruttore
    public function __construct(){

      $this->currentUser = null;

      //1.se non sei loggato puoi accedere solo ad index e a show
      $this->middleware('auth'); //NON PASSATO? REGISTER O LOGIN

      //tutti gli user registrati hanno permesso di
      //gestire la propria messaggistica,
      //esplicitiamo comunque questa possibilità
      $this->middleware('permission:manage-owner');

      //In caso non si soddisfino le proprietà si riviene
      //mandati alla pagina 403:forbidden

      //Popoliamo la var user del controller
      //per non dover ripetere la ricerca ogni volta
      $this->middleware(function ($request, $next) {

        $this->currentUser = Auth::user();

        $this->currentUser->role = $this->currentUser->roles()->first()->name;


        return $next($request);

      });

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($apartmentId)
    {
        //Il controllo che sia owner sarà fatto poi sul costruttore
        $owner = Auth::user();

        //Da controllare che l'apartment id sia veramente dello user

        $apartment = Apartment::find($apartmentId);
        // dd($apartment);
        $plans = Plan::all();

        return view('admin.owner.sponsor', compact('owner','plans','apartment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         // Recupero il piano
          $plan = Plan::findOrFail($request->plan_id);

          // subscribe the user
          $request->user()->newSubscription('main', $plan->braintree_plan)->create($request->payment_method_nonce);

          // redirect to home after a successful subscription
          return redirect()->route('owner.show', $request->user()->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
