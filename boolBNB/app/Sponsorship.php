<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
  //Associazione tabella
  protected $table = 'sponsorships';

  //created_at e updated_at gestite da Eloquent
  public $timestamps = true;

  //Proprietà fillabili
  protected $fillable = [
                          'name',
                          'duration',
                          'price',
                        ];

  //********RELAZIONI*****************//

  //RELAZIONE UTENTI(MANY) <---> SPONSORIZZAZIONI(MANY)
  //Un utente ha molte sponsorizzazioni
  //un (tipo di) sponsorizzazione può avere molti utenti
  public function users(){
    return $this->belongsToMany('App\User');
  }

  //RELAZIONE APPARTAMENTO(MANY) <---> SPONSORIZZAZIONE(MANY)
  //Un appartamento ha una sola sponsorizzazione alla volta, ma può averne molte totali
  //Una sponsorizzazion può avere multipli appartamenti
  public function apartments(){
    return $this->belongsToMany('App\Sponsorship');
  }

}
