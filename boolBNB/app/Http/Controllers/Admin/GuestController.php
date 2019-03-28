<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class GuestController extends Controller
{
      //variabile per conservare l'utente
      // che passa sul controller
      //e il suo ruolo
      protected $guest;

      //middleware permessi sul costruttore
      public function __construct(){



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

          $this->guest = Auth::user();

          //ci servirà al momento dell unificazione controller
          $this->guest->role = $this->guest->roles()->first()->name;


          return $next($request);

        });

      }

    public function show()
    {

        return view('admin.guest.dashboard',  ['guest' => $this->guest]);

    }

    public function profile(){

      return view('admin.guest.profile', ['guest' => $this->guest]);

    }

    public function edit()
    {

        return view('admin.guest.edit', ['guest' => $this->guest]);
    }


    public function update(Request $request)
    {
        return redirect()->route('guest.show');
    }

    public function destroy()
    {
        $this->guest->delete();

        return redirect()->route('guest.show');
    }

    public function updatePassword(Request $request){

      $data =$request->all();
      //$this->currentUser->Password

      //$oldPassword = Hash::make($data['old_password']);
      $this->validate($request, ['old_password' => 'required', 'new_password' => 'required|confirmed|min:8', 'new_password_confirmation' => 'required|min:8']);
      if (Hash::check($data['old_password'], Auth::user()->password)) {
        //dd('vecchia password corretta');
           User::find(Auth::id())->fill([
            'password' => Hash::make($data['new_password'])
            ])->save();

           //$request->session()->flash('success', 'Password changed');

            return redirect()->route('guest.profile', ['success' => 'Cambio password avvenuto con successo']);

        } else {
          //dd('vecchia password sbagliata');
            //$request->session()->flash('error', 'Password does not match');
            return view('admin.guest.edit', ['error' => 'La vecchia password non è corretta']);
        }


    }


}
