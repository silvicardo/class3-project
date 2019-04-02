0
1 0 silvicardo/class3-project
 Code  Issues 0  Pull requests 0  Projects 0  Wiki  Insights
class3-project/boolBNB/database/migrations/2019_03_18_113307_create_apartments_table.php
@silvicardo silvicardo Relazioni -> Appartamento e Prenotazioni, Utenti e Sponsorizzazioni, …
15de84a 14 days ago
53 lines (47 sloc)  2.02 KB

<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('title', 30)->nullable(false);//Titolo inserzione
            $table->tinyInteger('nr_of_rooms')->nullable(false);
            $table->tinyInteger('nr_of_beds')->nullable(false);
            $table->tinyInteger('nr_of_bathrooms')->nullable(false);
            $table->text('description')->nullable(false);//Descrizione appartamento
            $table->smallInteger('mq')->nullable(false)->comment('metri quadrati');
            $table->smallInteger('daily_price')->nullable(false);
            //indirizzi sempre diversi, non si può dare una stringa identica,
            //l'utente può differenziare magari mettendo un interno/piano
            $table->string('address', 100)->nullable(false)->unique(); //Via talDeiTali 23, Roma, RM, CAP
            //https://laracasts.com/discuss/channels/laravel/what-type-of-column-type-should-i-use-for-storing-latitude-and-longitude?page=1
            //Latitudes range from -90 to +90 (degrees),
            //so DECIMAL(10, 8) is ok for that, but longitudes range
            //from -180 to +180 (degrees) so you need DECIMAL(11, 8).
            $table->decimal('latitude', 10,8);  //la logica nei controller compilerà questo dato
            $table->decimal('longitude', 11, 8); //la logica nei controller compilerà questo dato
            $table->text('image_url')->nullable(false);
            //Nel caso si volesse fare un json per gli optionals
            // $table->json('options');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}
