<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class GuestController extends Controller
{
      //variabile per conservare l'utente
      // che passa sul controller
      //e il suo ruolo
      protected $currentUser;

      //middleware permessi sul costruttore
      public function __construct(){

        //$this->currentUser = null;//

        //1.se non sei loggato puoi accedere solo ad index e a show
        $this->middleware('auth'); //NON PASSATO? REGISTER O LOGIN

        //tutti gli user registrati hanno permesso di
        //gestire la propria messaggistica,
        //esplicitiamo comunque questa possibilità
        $this->middleware('permission:manage-guest');

        //In caso non si soddisfino le proprietà si riviene
        //mandati alla pagina 403:forbidden

        //Popoliamo la var user del controller
        //per non dover ripetere la ricerca ogni volta
        $this->middleware(function ($request, $next) {

          $this->currentUser = Auth::user();

          //ci servirà al momento dell unificazione controller
          $this->currentUser->role = $this->currentUser->roles()->first()->name;


          return $next($request);

        });

      }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        $guest = User::find($id);
        /*$userApartments = null;
        if (count($currentUser->apartments) > 0)
        {
          $userApartments = $currentUser->apartments;
        }*/
        return view('admin.guest.dashboard', compact('guest'));

    }

    public function profile($id){

      $guest = User::find($id);

      return view('admin.guest.profile', compact('guest'));

    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guestToEdit = User::find($id);
        return view('admin.guest.edit', compact('guestToEdit'));
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

        $guestToDelete = User::find($id);
        $guestToDelete->delete();
        return redirect()->route('admin.guest.dashboard');
    }
}
