<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Creiamo i ruoli!

        $proprietario = new Role();
        $proprietario->name         = 'owner';//notnull - unique
        $proprietario->display_name = 'Utente Proprietario';
        $proprietario->description  = 'Utente che affitta appartamenti';
        $proprietario->save();

        $ospite = new Role();
        $ospite->name         = 'guest';
        $ospite->display_name = 'User Administrator';
        $ospite->description  = 'Utente ospite degli appartamenti';
        $ospite->save();
    }
}
