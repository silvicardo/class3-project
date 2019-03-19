<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsorships', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 40)->nullable(false)->comment('ex: 2 giorni in evidenza!');
            //duration -> in giorni esempio: 3, uniche 1 sponsorizzazione per ammontare di giorni
            $table->smallInteger('duration')->nullable(false)->unique();
            $table->smallInteger('price')->nullable(false); //valuta €, prezzo non unico per eventuali scontistiche
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsorships');
    }
}
