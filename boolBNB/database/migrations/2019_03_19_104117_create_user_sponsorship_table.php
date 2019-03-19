<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSponsorshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sponsorship', function (Blueprint $table) {

          //TABELLA PONTE MANY TO MANY UTENTI <---> SPONSORIZZAZIONI
          $table->unsignedInteger('user_id');
          $table->unsignedInteger('sponsorship_id');

          $table->foreign('user_id')->references('id')->on('users');
          $table->foreign('sponsorship_id')->references('id')->on('sponsorships');

          $table->primary(['user_id', 'sponsorship_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sponsorship');
    }
}
