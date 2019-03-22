<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['subject', 'description_body', 'recipient_mail', 'sender_id'];

    protected $table = 'messages';

    //Relazioni Utenti(ONE)<-> MESSAGGI(MANY)

    //un messsaggio puo' avere un mittente,quindi 1 solo proprietario
    //un utente puo' avere tanti messaggi

    public function user()
    {
      return $this->belongsTo('App\User');
    }

}
