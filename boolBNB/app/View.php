<?php

namespace App;
use App\View;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';

    //Relazioni Appartamenti(ONE)<-> MESSAGGI(MANY)

    //un appartamento può avere tante views(visualizzazioni)
    //una singola visualizzazione può avere un solo appartamento

    public function apartment()
    {
      return $this->belongsTo('App\Apartment');
    }


}
