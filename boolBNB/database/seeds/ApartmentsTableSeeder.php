<?php

use Illuminate\Database\Seeder;
use App\Apartment;
use App\Optional;
use Faker\Generator as Faker;
use App\User;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {

      //DA STUDIARE
      //https://guzzle.readthedocs.io/en/latest/
      //creiamo 30 combinazioni latitudine longitudine con faker
      //chiamata api da php, il seeder potrebbe chiamare l'Api di localizzazione
      //per generare un indirizzo verosimile
      //per ora popolo con indirizzo e latitudine+longitudine non relazionati

      // for ($i=0; $i < 5; $i++) {
      //
      //   $newApartment = new Apartment;
      //   $newApartment->user_id = User::find(1)->id;//1 proprietario , 2 ospite
      //   $newApartment->title = 'Appartamento';
      //   $newApartment->nr_of_rooms = $faker->numberBetween(1,10);
      //   $newApartment->nr_of_beds = $faker->numberBetween(1,20);
      //   $newApartment->nr_of_bathrooms = $faker->numberBetween(1,3);
      //   $newApartment->description = $faker->paragraph(5, true);
      //   $newApartment->mq = $faker->numberBetween(30,120);
      //   $newApartment->daily_price = $faker->numberBetween(30,200);
      //   $newApartment->address = $faker->address;
      //   $newApartment->latitude = $faker->latitude;
      //   $newApartment->longitude = $faker->longitude;
      //   $newApartment->image_url = $faker->imageUrl(640, 480, 'city');
      //   $newApartment->save();
      //   $newApartment->optionals()->sync([1, 2]);
      //   $newApartment->save();
      //
      //   //NOTA
      //   //per popolare gli optionals randomicamente quando ci saranno le relazioni
      //   // randomElements($array = array ('a','b','c'), $count = 1) // array('c')
      // }


      $newApartment = new Apartment;
      $newApartment->user_id = User::find(1)->id;//1 proprietario , 2 ospite
      $newApartment->title = 'App Milano';
      $newApartment->nr_of_rooms = $faker->numberBetween(1,10);
      $newApartment->nr_of_beds = $faker->numberBetween(1,20);
      $newApartment->nr_of_bathrooms = $faker->numberBetween(1,3);
      $newApartment->description = $faker->paragraph(5, true);
      $newApartment->mq = $faker->numberBetween(30,120);
      $newApartment->daily_price = $faker->numberBetween(30,200);
      $newApartment->address = 'Via Monte Rosa, 91, Milano';
      $newApartment->latitude = 45.477936;
      $newApartment->longitude = 9.1429304;
      $newApartment->image_url = $faker->imageUrl(640, 480, 'city');
      $newApartment->save();
      $newApartment->optionals()->sync([1, 2]);
      $newApartment->save();


      $newApartment = new Apartment;
      $newApartment->user_id = User::find(1)->id;//1 proprietario , 2 ospite
      $newApartment->title = 'App Firenze';
      $newApartment->nr_of_rooms = $faker->numberBetween(1,10);
      $newApartment->nr_of_beds = $faker->numberBetween(1,20);
      $newApartment->nr_of_bathrooms = $faker->numberBetween(1,3);
      $newApartment->description = $faker->paragraph(5, true);
      $newApartment->mq = $faker->numberBetween(30,120);
      $newApartment->daily_price = $faker->numberBetween(30,200);
      $newApartment->address = 'Via Cesare Cocchi, Firenze';
      $newApartment->latitude = 43.7962437;
      $newApartment->longitude = 11.2401303;
      $newApartment->image_url = $faker->imageUrl(640, 480, 'city');
      $newApartment->save();
      $newApartment->optionals()->sync([1, 2]);
      $newApartment->save();
    }
}
