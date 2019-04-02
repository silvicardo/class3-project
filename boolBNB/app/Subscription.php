<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    //RELAZIONE APPARTAMENTO(ONE) <--->  SUBSCRIPTIONS(MANY)
    //Un appartamento può avere una subscription alla volta, ma molte nel tempo
    //Una subscription può avere un singolo appartamento
    public function apartment(){
      return $this->belongsTo('App\Apartment');
    }


}
