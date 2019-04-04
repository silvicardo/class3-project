<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['subject', 'description_body', 'recipient_mail', 'sender_id', 'apartment_id'];

    protected $table = 'messages';

    //Relazioni Utenti(ONE)<-> MESSAGGI(MANY)

    //un messsaggio puo' avere un mittente,quindi 1 solo proprietario
    //un utente puo' avere tanti messaggi

    public function user()
    {
      return $this->belongsTo('App\User');
    }


    //Relazioni Appartamenti(ONE)<-> MESSAGGI(MANY)

    //un appartamento può avere tanti messaggi
    //un singolo messaggio può avere un solo appartamento

    public function apartment()
    {
      return $this->belongsTo('App\Apartment');
    }
}
