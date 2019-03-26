<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Subscription;

class OwnerController extends Controller
{

      //variabile per conservare l'utente
      // che passa sul controller
      //e il suo ruolo
      protected $currentUser;

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

        //Popoliamo la var user del controller
        //per non dover ripetere la ricerca ogni volta
        $this->middleware(function ($request, $next) {

          $this->currentUser = Auth::user();

          $this->currentUser->role = $this->currentUser->roles()->first()->name;


          return $next($request);

        });

      }


    public function show()
    {

      return view('admin.owner.dashboard', ['currentUser' => $this->currentUser]);
    }

    public function profile(){


      return view('admin.owner.profile', ['currentUser' => $this->currentUser]);

    }

    public function edit()
    {

        //passare la view con il dato//
        return view('admin.owner.edit', ['currentUser' => $this->currentUser]);
    }

    public function update(Request $request)
    {
      return redirect()->route('owner.show');

    }

    public function destroy()
    {

        $this->currentUser->delete();

        return redirect()->route('owner.show');

    }
    public function sponsor() {

        //da fare passare tipi di Sponsor//
        return view('admin.owner.sponsor', ['currentUser' => $this->currentUser, 'allSponsors' => Subscription::all()]);
    }
}
