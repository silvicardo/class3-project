<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;

class HomeController extends Controller
{

   public function index()
   {
       $allApartments = Apartment::all();

       return view('home', compact('allApartments'));
   }
}
