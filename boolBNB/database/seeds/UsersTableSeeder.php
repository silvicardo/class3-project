<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
// use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //recuperiamo i ruoli
        $proprietario = Role::where('name', '=', 'proprietario')->first();
        $ospite = Role::where('name', '=', 'ospite')->first();

        //crezione proprietario
        $ownerTestUser = new User;
        $ownerTestUser->name = 'Proprietario';
        $ownerTestUser->email = 'proprietario@test.com';
        //password momentaneamente in chiaro per il seeder
        $ownerTestUser->password = bcrypt('proprietario');
        $ownerTestUser->save();

        //creazione user ospite
        $guestTestUser = new User;
        $guestTestUser->name = 'Ospite';
        $guestTestUser->email = 'ospite@test.com';
        //password momentaneamente in chiaro per il seeder
        $guestTestUser->password = bcrypt('ospite1234');
        $guestTestUser->save();

        //aggiunta ruolo agli utenti salvati
        $ownerTestUser->attachRole($proprietario);//assegnazione ruolo
        $guestTestUser->attachRole($ospite);//assegnazione ruolo
    }
}
