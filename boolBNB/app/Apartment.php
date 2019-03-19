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
                            'description',
                            'mq',
                            'daily_price',
                            'address',
                            'image_url'
                          ];

    //Proprietà da assegnare singolarmente
    protected $guarded = ['latitude', 'longitude'];

    //RELAZIONE APPARTAMENTO <--->OPTIONALS - MANY TO MANY(MANY appartamento - MANY Optionals)
    public function optionals(){
      return $this->belongsToMany('App\Optional');
    }

}
