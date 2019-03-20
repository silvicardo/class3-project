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

   public function create(){

     //da inserire  la logica di autenticazione
     //da determinare se Utente:
     //-> Loggato (middleware Auth)   Ok!!
     //->Ruolo Proprietario o Ospite(middleware Ruoli)

     //if (utente è proprietario)
     // return view('appartamento.create', compact('idUtente')
     //else (utente è ospite)
     //return una view che dica che non sei autorizzato

     $data = [
       'action' => route('apartment.store'),
       'method' => 'POST',
     ];

     return view('apartment.create');

   }
}
