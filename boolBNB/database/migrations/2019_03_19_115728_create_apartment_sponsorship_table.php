<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentSponsorshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_sponsorship', function (Blueprint $table) {

          //TABELLA PONTE MANY TO MANY UTENTI <---> SPONSORIZZAZIONI
          $table->unsignedInteger('apartment_id');
          $table->unsignedInteger('sponsorship_id');

          $table->foreign('apartment_id')->references('id')->on('apartments');
          $table->foreign('sponsorship_id')->references('id')->on('sponsorships');

          $table->primary(['apartment_id', 'sponsorship_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_sponsorship');
    }
}
