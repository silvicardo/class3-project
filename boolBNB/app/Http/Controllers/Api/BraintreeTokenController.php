<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Braintree_ClientToken;

class BraintreeTokenController extends Controller
{
    //GENERIAMO IL TOKEN PER LA SPONSOR PAGE
     public function token()
    {
        return response()->json([
            'data' => [
                'token' => Braintree_ClientToken::generate(),
            ]
        ]);
    }
}
