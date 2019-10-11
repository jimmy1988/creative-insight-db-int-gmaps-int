<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->integer('place_id')->autoIncrement();
            $table->string('place_id_hash')->unique();
            $table->string('place_name');
            $table->string('place_address_1');
            $table->string('place_address_2')->nullable();
            $table->string('place_address_3')->nullable();
            $table->string('place_address_area')->nullable();
            $table->string('place_address_city');
            $table->string('place_address_county');
            $table->string('place_address_postcode');
            $table->string('place_location_lat');
            $table->string('place_location_lng');
            $table->integer('place_status');
            $table->dateTime('place_date_last_updated')->nullable();
            $table->dateTime('place_date_created')->useCurrent();
            $table->dateTime('place_date_deleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        Schema::dropIfExists('places');
    }
}
