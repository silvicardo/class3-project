<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripsController extends Controller
{

    public function index()
    {
        return view('home.trips');
    }
}
