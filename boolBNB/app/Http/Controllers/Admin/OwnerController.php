<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class OwnerController extends Controller
{


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $currentUser = User::find($id);
      // dd($currentUser->apartments);
      /*dd($currentUser->apartments);*/
      $userApartments = null;
      if (count($currentUser->apartments) > 0)
      {

        $userApartments = $currentUser->apartments;

      }
      // dd($userApartments);

      return view('admin.owner.dashboard', compact('currentUser', 'userApartments'));


    }

    public function profile($id){

      $currentUser = User::find($id);

      return view('admin.owner.profile', compact('currentUser'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //prender l utente dal db//
        $ownerToEdit = User::find($id);
        //passare la view con il dato//
        return view('admin.owner.edit', compact('ownerToEdit'));
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
        $ownerToDelete = User::find($id);
        $ownerToDelete->delete();

        return redirect()->route('admin.owner.dashboard');

    }
}
