<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;

class ApartmentController extends Controller
{

    public function index()
    {
        return view('home.apartment');
    }

    public function show($id)
    {
<<<<<<< HEAD
      $foundApartment = Apartment::find($id);

      return view('home.apartment');
=======
        $foundApartment = Apartment::find($id);

        return view('apartment.show');
>>>>>>> 25f7ed16551ac9fc3ccd473fbd856f3d1ef89ef9
    }
}
