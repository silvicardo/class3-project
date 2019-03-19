<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;


class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Creiamo i permessi!


        //Recuperiamo i ruoli
        $proprietario = Role::where('name', '=', 'proprietario')->first();
        $ospite = Role::where('name', '=', 'ospite')->first();


        //******PERMESSI APPARTAMENTI*****//

        $viewApartment = new Permission();
        $viewApartment->name         = 'view-apartment';
        $viewApartment->display_name = 'View Apartments'; // optional
        $viewApartment->description  = 'view apartments show page'; // optional
        $viewApartment->save();

        $searchApartment = new Permission();
        $searchApartment->name         = 'search-apartment';
        $searchApartment->display_name = 'Search Apartments'; // optional
        $searchApartment->description  = 'enter search apartments page'; // optional
        $searchApartment->save();

        $createApartment = new Permission();
        $createApartment->name         = 'create-apartment';
        $createApartment->display_name = 'Create New Apartments'; // optional
        $createApartment->description  = 'create new apartments'; // optional
        $createApartment->save();

        $editApartment = new Permission();
        $editApartment->name         = 'edit-apartment';
        $editApartment->display_name = 'Edit Apartments'; // optional
        $editApartment->description  = 'edit apartments'; // optional
        $editApartment->save();

        $deleteApartment = new Permission();
        $deleteApartment->name         = 'delete-apartment';
        $deleteApartment->display_name = 'Delete Apartments'; // optional
        $deleteApartment->description  = 'delete apartments'; // optional
        $deleteApartment->save();

        //******PERMESSI SPONSORIZZAZIONI*****//
        //Creare-cancellare
        $manageSponshorship = new Permission();
        $manageSponshorship->name         = 'manage-sponsorship';
        $manageSponshorship->display_name = 'Manage Sponshorships'; // optional
        $manageSponshorship->description  = 'manage sponsorships'; // optional
        $manageSponshorship->save();

        //*********************************//
        //******PERMESSI PRORIETARIO*******//
        //*********************************//
        $proprietario->attachPermission([
                                          $viewApartment,
                                          $createApartment,
                                          $editApartment,
                                          $deleteApartment,
                                          $manageSponshorship,
                                          $searchApartment
                                        ]);

      //****************************//
      //******PERMESSI OSPITE*******//
      //****************************//
      $ospite->attachPermission([$viewApartment, $searchApartment]);


    }
}
