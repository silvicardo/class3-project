<?php

use Illuminate\Database\Seeder;

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
         $this->call([
                        UsersTableSeeder::class,
                        OptionalsTableSeeder::class,
                        ApartmentsTableSeeder::class,
         ]);
    }
}
