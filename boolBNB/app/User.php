<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Laravel\Cashier\Billable; //per le sponsorizzazioni

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait; // add this trait to your user model
    use Billable; //Billable Trait
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image_profile'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //********RELAZIONI*****************//

    //RELAZIONE UTENTI(ONE) <-> APPARTAMENTI(MANY)
    //Un utente ha molti appartamenti
    //Un appartamento ha un solo utente
    public function apartments()
    {
        return $this->hasMany('App\Apartment');
    }

    //RELAZIONE UTENTI(ONE) <-> PRENOTAZIONI(MANY)
    //Un utente ha molte prenotazioni
    //Una prenotazione ha un solo utente
    public function reservations()
    {
        return $this->hasMany('App\Reservation');
    }


    //Andranno sostituite con le subscriptions
    //RELAZIONE UTENTI(MANY) <---> SPONSORIZZAZIONI(MANY)
    //Un utente ha molte sponsorizzazioni
    //un (tipo di) sponsorizzazione può avere molti utenti
    // public function sponshorships(){
    //   return $this->belongsToMany('App\Sponsorship');
    // }

    //Relazioni Utenti(ONE)<-> MESSAGGI(MANY)
    //un messsaggio puo' avere un mittente,quindi 1 solo proprietario
    //un utente puo' avere tanti messaggi

    public function messages()
    {
      return $this->hasMany('App\Message');
    }

}
