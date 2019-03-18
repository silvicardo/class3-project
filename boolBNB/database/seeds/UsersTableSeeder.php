<?php

use Illuminate\Database\Seeder;
use App\User;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i=0; $i < 5; $i++) {

          $newUser = new User;
          $newUser->name = $faker->name;
          $newUser->email = $faker->freeEmail;
          //password momentaneamente in chiaro per il seeder
          $newUser->password = $faker->password;
          $newUser->save();

        }
    }
}
