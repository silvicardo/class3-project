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

}
