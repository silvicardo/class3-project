<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
  //Associazione tabella
  protected $table = 'optionals';

  //created_at e updated_at gestite da Eloquent
  public $timestamps = true;

  //Proprietà fillabili
  protected $fillable = ['name'];

  //RELAZIONE APPARTAMENTO <--->OPTIONALS - MANY TO MANY(MANY appartamento - MANY Optionals)
  public function apartments(){
    return $this->belongsToMany('App\Apartment');
  }

}
