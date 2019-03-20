<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;


class HomeController extends Controller
{


   public function index()
   {


       $allApartments = Apartment::all();

      //Abbreviamo la descrizione per il frontend
       foreach ($allApartments as &$apartment) {
         $apartment->description = implode(' ', array_slice(explode(' ', $apartment->description), 0, 30));
       }

       return view('home', compact('allApartments'));
   }

}
