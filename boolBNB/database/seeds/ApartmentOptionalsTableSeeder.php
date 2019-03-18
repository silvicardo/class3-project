<?php

use Illuminate\Database\Seeder;
//importo il model relativo
use App\ApartmentOptional;

class ApartmentOptionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Popolo il db con gli optionals di default
        $optionals = ['WiFi', 'Posto Macchina', 'Piscina', 'Portineria', 'Sauna', 'Vista Mare'];

        foreach ($optionals as $optional) {

          $newOptional = new ApartmentOptional;
          $newOptional->name = $optional;
          $newOptional->save();
        }
    }
}
