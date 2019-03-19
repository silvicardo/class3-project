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
        $foundApartment = Apartment::find($id);

        return view('apartment.show', compact('foundApartment'));
    }
}
