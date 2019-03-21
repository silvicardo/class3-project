<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class GuestController extends Controller
{
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
