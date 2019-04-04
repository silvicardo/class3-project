<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Apartment;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Auth;
use App\Optional;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class ApartmentController extends Controller
{
    //middleware permessi sul costruttore
    public function __construct(){
      //1.se non sei loggato puoi accedere solo ad index e a show
      $this->middleware('auth')->except(['index', 'show']); //NON PASSATO? REGISTER O LOGIN
      //if user non ha un ruolo Auth::user() null
      //escludere le rotte index e show e farle vedere comunque
      //al netto del middleware Auth
      //2.Puoi accedere a index e show se hai i permessi per
      //vedere e ricercare (sia ospite che proprietario)
      $this->middleware([
                          'permission:view-apartment',
                          'permission:search-apartment'
                        ])->except(['index', 'show']);;
      //3.Solo i proprietari hanno i set dei permessi
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
      $allApartments = Apartment::all();
     //Abbreviamo la descrizione per il frontend
      foreach ($allApartments as &$apartment) {
        $apartment->description = implode(' ', array_slice(explode(' ', $apartment->description), 0, 30));
      }
        return view('apartment.index', compact('allApartments'));
    }
    public function show($apartmentId)

  {

        $foundApartment = Apartment::find($apartmentId);
        return view('apartment.show', compact('foundApartment'));
    }
    public function create(){
      //MIDDLEWARE SUL COSTRUTTORE
      //se Utente:
      //-> Loggato (middleware Auth)   Ok!!
      //->Ruolo Proprietario (middleware Ruoli)
      //if (utente è proprietario)
      // return view('appartamento.create', compact('DATA')
      //else (utente è ospite)
      //return una view che dica che non sei autorizzato(403 FORBIDDEN)
      $data = [
        'availableOptionals' => Optional::all(),
        'action' => 'apartment.store',
        'method' => 'POST',
        'h2' => 'Aggiungi Nuovo Appartamento',
        'button' => 'Salva Appartamento',
      ];
      return view('apartment.create_edit', compact('data'));
    }
    public function store(Request $request, Faker $faker){
        $data = $request->all();

        $data['image_url'] = Storage::disk('public')->put('image_apartment', $data['image_url']);
        
        //validazione dei dati da fare
        $newApartment = new Apartment;
        $newApartment->fill($data);
        $newApartment->user_id = Auth::user()->id;
        //per ora dato fake per lat e lon
        $newApartment->latitude = $data['latitude'];
        $newApartment->longitude = $data['longitude'];
        $newApartment->save();
        $newApartment->optionals()->sync($data['optionals']);
        return redirect()->route('owner.show');
    }
    public function edit($apartmentId){
      $foundApartment = Apartment::find($apartmentId);
      $apartmentOptionals = $foundApartment->optionals()->get()->toArray();
      $optionalsIds = [];
      foreach ($apartmentOptionals as $optional) {
        $optionalsIds[] = $optional['id'];
      }
      $data = [
        'availableOptionals' => Optional::all(),
        'apartmentOptionalsIds'=> $optionalsIds,
        'action' => 'apartment.update',
        'method' => 'PUT',
        'h2' => 'Modifica Appartamento',
        'button' => 'Salva modifiche appartamento',
      ];
      return view('apartment.create_edit', compact('data', 'foundApartment'));
    }
    public function update(Request $request, $id){
      //i dati modificati dal form
      $data = $request->all();
      if (!empty($data['image_url'])){
        $data['image_url'] = Storage::disk('public')->put('image_apartment', $data['image_url']);
      }
      $apartment = Apartment::find($id);
      //aggiorniamo l'appartamento arrivato dal form di rimande dalla rotta edit
      $apartment->update($data);
      $apartment->latitude = $data['latitude'];
      $apartment->longitude = $data['longitude'];
      //salviamo il dato aggiornato
      $apartment->save();
      $apartment->optionals()->sync($data['optionals']);
      $apartment->save();
      //rimandiamo alla show
      return redirect()->route('owner.show');
    }
    public function destroy($apartmentId){
      $foundApartment = Apartment::find($apartmentId);
      $foundApartment->optionals()->detach();
      //if foundApartment non è null
      $foundApartment->delete();
      //rimandiamo alla dashboard
      //alla delete accede solo PROPRIETARIO
      //ogni altro utente sarà già stato stoppato dai MIDDLEWARE
      //PROPRIETARIO avrà probabilmente premuto un bottone cancella
      //nella dashboard o comunque vorrà vedere lo stato
      //dei suoi appartamenti dopo la cancellazion
      //non ritorniamo la view secca senò lui vedrebbe sempre gli stessi appartamenti
      //ma facciamo fornire la view dal controller richiamandone il name
      //che appunto chiamera il controller dalle rotte
      //che interrogherà il database e fornirà
      //gli appartamenti di quell'utente aggiornati al netto della cancellazione
      // return redirect()->route('admin.owner.index');
       return redirect()->route('owner.show');
    }
}
