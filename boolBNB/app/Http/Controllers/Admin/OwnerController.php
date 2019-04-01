<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Subscription;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class OwnerController extends Controller {
  //middleware permessi sul costruttore
  public function __construct() {
    //1.se non sei loggato puoi accedere solo ad index e a show
    $this->middleware('auth'); //NON PASSATO? REGISTER O LOGIN
    //tutti gli user registrati hanno permesso di
    //gestire la propria messaggistica,
    //esplicitiamo comunque questa possibilità
    $this->middleware('permission:manage-owner');
    //In caso non si soddisfino le proprietà si riviene
    //mandati alla pagina 403:forbidden
  }

  public function show() {
    return view('admin.owner.dashboard', ['currentUser' =>  Auth::user()]);
  }

  public function profile() {
    return view('admin.owner.profile', ['currentUser' =>  Auth::user()]);
  }

  public function edit() {
    //passare la view con il dato//
    return view('admin.owner.edit', ['currentUser' =>  Auth::user()]);
  }

  public function update(Request $request) {
    return redirect()->route('owner.show');
  }

  public function destroy() {
    Auth::user()->delete();
    return redirect()->route('owner.show');
  }

  public function sponsor() {
    //da fare passare tipi di Sponsor//
    return view('admin.owner.sponsor', ['currentUser' =>  Auth::user(), 'allSponsors' => Subscription::all()]);
  }

  public function updatePassword(Request $request) {
    $data = $request->all();
    //Auth::user()->Password
    //$oldPassword = Hash::make($data['old_password']);
    $this->validate($request, ['old_password' => 'required', 'new_password' => 'required|confirmed|min:8', 'new_password_confirmation' => 'required|min:8']);
    if (Hash::check($data['old_password'],  Auth::user()->password)) {
      //dd('vecchia password corretta');
      User::find(Auth::id())->fill([
        'password' => Hash::make($data['new_password'])
        ])->save();
      //$request->session()->flash('success', 'Password changed');
      return redirect()->route('owner.profile', ['success' => 'Cambio password avvenuto con successo']);
    } else {
      //dd('vecchia password sbagliata');
      //$request->session()->flash('error', 'Password does not match');
      return view('admin.owner.edit', ['error' => 'La vecchia password non è corretta']);

    }
  }


  public function profilePictureUpdate(Request $request) {
    $data = $request->all();
    $data['image_profile'] = Storage::disk('public')->put('image_profile', $data['image_file']);

    Auth::user()->update($data);
    return redirect()->route('owner.profile');
  }

  public function stats(){

    return view('admin.owner.stats', ['currentUser' => Auth::user()]);
  }

}
