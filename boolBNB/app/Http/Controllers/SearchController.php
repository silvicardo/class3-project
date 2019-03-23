<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use App\Optional;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $data = $request->all();

        $citta_cercata = $data['citta_cercata'];
        $optionals = Optional::all();

        return view('home.search', compact('citta_cercata','optionals'));
    }


}
