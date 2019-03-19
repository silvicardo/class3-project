<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Apartment;
use Faker\Generator as Faker;

class ApartmentController extends Controller
{

    //middleware permessi sul costruttore
    public function __construct(){

      //se non sei loggato puoi accedere solo ad index e a show
      $this->middleware('auth')->except(['index', 'show']);

      //al netto del middleware Auth

      //Puoi accedere a index e show se hai i permessi per
      //vedere e ricercare (sia ospite che proprietario)
      $this->middleware([
                          'permission:view-apartment',
                          'permission:search-apartment'
                        ]);

      //Solo i proprietari hanno i set dei permessi
      //per fare modifiche
      $this->middleware([
                          'permission:create-apartment',
                          'permission:edit-apartment',
                          'permission:delete-apartment',
                        ])->except(['index', 'show']);

    //In caso non si soddisfino le proprietà si riviene
    //mandati alla pagina 403:forbidden
    }

    public function index()
    {
        return view('apartment.index');
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


    public function store(Request $request, Faker $faker){

        $data = $request->all();
        $newApartment->fill($data);
        //per ora dato fake per lat e lon
        $newApartment->latitude = $faker->latitude;
        $newApartment->longitude = $faker->longitude;
        $newApartment->save();

        return redirect()->route('user.index');
    }

    public function edit(Apartment $apartment){

      $data = [
        'action' => route('apartment.update', $apartment->id),
        'method' => 'POST',
      ];

      return view('apartment.edit', $data);

    }

    public function update(Request $request, Apartment $apartment){

      $data = $request->all();

      $newApartment->update($data);

      $newApartment->save();

      return redirect()->route('user.index');
    }

    public function destroy(Apartment $apartment){

      $apartment->delete();

      return view('apartment.index', $data);

    }
}
