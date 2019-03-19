<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserToReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {

          //aggiungi la colonna user_id in reservations
          $table->unsignedInteger('user_id')->after('id');

          //user_id in reservations è collegata con id in users
          $table->foreign('user_id')->references('id')->on('users');
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
          $table->dropForeign('reservations_user_id_foreign');
          
        });
    }
}
