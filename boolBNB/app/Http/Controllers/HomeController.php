<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\User;
use App\Subscription;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


   public function index()
   {

       $subscriptions = Subscription::orderBy('id', 'desc')->take(6)->get();

       $sponsoredApartments = [];

       foreach ($subscriptions as $subscription) {

        $sponsoredApartments[] = $subscription->apartment;

      }

       $allApartments = Apartment::all();

      //Abbreviamo la descrizione per il frontend
       foreach ($allApartments as &$apartment) {
         $apartment->description = implode(' ', array_slice(explode(' ', $apartment->description), 0, 30));
       }

       return view('home', compact('allApartments','sponsoredApartments'));
   }

}
