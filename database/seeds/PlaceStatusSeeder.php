<?php

use Illuminate\Database\Seeder;

class PlaceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('place_status')->insert([
        ['place_status' => "Active"],
        ['place_status' => "Suspended"],
        ['place_status' => "Deleted"]
      ]);

    }
}
