<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApartmentToReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {

          //aggiungi la colonna apartment_id in reservations
          $table->unsignedInteger('apartment_id')->after('id');

          //apartment_id in reservations è collegata con id in apartments
          $table->foreign('apartment_id')->references('id')->on('apartments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {

          //Droppo la foreign
          $table->dropForeign('reservations_apartment_id_foreign');
        });
    }
}
