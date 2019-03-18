<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApartmentOptional extends Model
{
  //Associazione tabella
  protected $table = 'apartment_optionals';

  //created_at e updated_at gestite da Eloquent
  public $timestamps = true;

  //Proprietà fillabili
  protected $fillable = ['name'];

}
