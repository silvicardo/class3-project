<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApartmentOptionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_optional', function (Blueprint $table) {
          
          //TABELLA PONTE MANY TO MANY APPARTAMENTI <---> OPTIONALS
          $table->unsignedInteger('apartment_id');
          $table->unsignedInteger('optional_id');

          $table->foreign('apartment_id')->references('id')->on('apartments');
          $table->foreign('optional_id')->references('id')->on('optionals');

          $table->primary(['apartment_id', 'optional_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_optional');
    }
}
