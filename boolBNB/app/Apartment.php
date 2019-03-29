<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    //Associazione tabella
    protected $table = 'apartments';

    //created_at e updated_at gestite da Eloquent
    public $timestamps = true;

    //Proprietà fillabili
    protected $fillable = [
                            'title',
                            'nr_of_rooms',
                            'nr_of_beds',
                            'nr_of_bathrooms',
                            'description',
                            'mq',
                            'daily_price',
                            'address',
                            'image_url'
                          ];

    //Proprietà da assegnare singolarmente
    protected $guarded = ['latitude', 'longitude'];

    //********RELAZIONI*****************//

    //RELAZIONE APPARTAMENTO <--->OPTIONALS
    // MANY TO MANY(MANY appartamento - MANY Optionals)
    public function optionals(){
      return $this->belongsToMany('App\Optional');
    }

    //RELAZIONE UTENTI(ONE) <-> APPARTAMENTI(MANY)
    //Un utente ha molti appartamenti
    //Un appartamento ha un solo utente
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    //RELAZIONE APPARTAMENTO(ONE) <-> PRENOTAZIONI(MANY)
    //Un appartamento ha molte prenotazioni
    //Una prentazione ha un solo appartamento
    public function reservations(){
      return $this->hasMany('App\Reservation');
    }

    //RELAZIONE APPARTAMENTO(MANY) <---> SPONSORIZZAZIONE(MANY)
    //Un appartamento ha una sola sponsorizzazione alla volta, ma può averne molte totali
    //Una sponsorizzazion può avere multipli appartamenti
    public function sponsorship(){
      return $this->belongsToMany('App\Sponsorship');
    }

    //Relazioni Appartamenti(ONE)<-> MESSAGGI(MANY)

    //un appartamento può avere tanti messaggi
    //un singolo messaggio può avere un solo appartamento


    public function messages()
    {
      return $this->hasMany('App\Message');
    }

}
