<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optionals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            //(WiFi, Posto Macchina, Piscina, Portineria, Sauna, Vista Mare) max 20 chars
            $table->string('name', 20)->nullable(false)->unique(); //Nomi unici
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('optionals');
    }
}
