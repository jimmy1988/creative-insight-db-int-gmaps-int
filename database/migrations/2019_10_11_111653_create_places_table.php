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
            $table->string('place_name')->index();
            $table->string('place_address_1')->index();
            $table->string('place_address_2')->nullable()->index();
            $table->string('place_address_3')->nullable()->index();
            $table->string('place_address_area')->nullable()->index();
            $table->string('place_address_city')->index();
            $table->string('place_address_county')->index();
            $table->string('place_address_postcode')->index();
            $table->string('place_location_lat')->index();
            $table->string('place_location_lng')->index();
            $table->integer('place_status')->default("1");
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
