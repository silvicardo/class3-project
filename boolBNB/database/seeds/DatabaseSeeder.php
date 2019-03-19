<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
          //per richiamare questo Seeder
          //php artisan db:seed
         $this->call([  RolesTableSeeder::class,
                        PermissionsTableSeeder::class,
                        UsersTableSeeder::class,
                        OptionalsTableSeeder::class,
                        ApartmentsTableSeeder::class,
         ]);
    }
}
