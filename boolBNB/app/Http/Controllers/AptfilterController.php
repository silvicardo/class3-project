<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AptfilterController extends Controller
{

    public function index()
    {
        return view('home.aptfilter');
    }
}
