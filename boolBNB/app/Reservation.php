<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
  //Associazione tabella
  protected $table = 'reservations';

  //created_at e updated_at gestite da Eloquent
  public $timestamps = true;

  //Proprietà fillabili
  protected $fillable = ['nr_of_days'];

  //********RELAZIONI*****************//

  //RELAZIONE UTENTI(ONE) <-> PRENOTAZIONI(MANY)
  //Un utente ha molte prenotazioni
  //Una prenotazione ha un solo utente
  public function user()
  {
      return $this->belongsTo('App\User');
  }

  //RELAZIONE APPARTAMENTO(ONE) <-> PRENOTAZIONI(MANY)
  //Un appartamento ha molte prenotazioni
  //Una prentazione ha un solo appartamento
  public function apartment(){
    return $this->belongsTo('App\Apartment');
  }

  //gli optionals di un appartamento saranno visibili tramite
  //la relazione con l'appartamento Prenotazione->Appartamento->Optionals

}
