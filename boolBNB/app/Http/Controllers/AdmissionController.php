<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lead;
use App\Mail\SendNewLead;
use Illuminate\Support\Facades\Mail;



class AdmissionController extends Controller
{
    public function index()
    {
      return view('admission.index');
    }


    public function save(Request $request)
    {
      $data = $request->all();

      $newLead = new Lead;

      $newLead->name = $data['name'];
      $newLead->email = $data['email'];
      $newLead->message = $data['message'];

      $newLead->save();

      $message = 'Complimenti,il tuo messaggio è stato spedito con successo!';

      Mail::to('diegoaneli@gmail.com')->send(new SendNewLead($newLead));

      return view('admission.index', compact('message'));



    }
}
