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
}
