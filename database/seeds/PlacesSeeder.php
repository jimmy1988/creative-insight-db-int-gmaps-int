<?php

use Illuminate\Database\Seeder;

class PlacesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('places')->insert([
        [
          'place_id_hash'=> sha1(uniqid("West_Bromwich").strtotime("now")),
          'place_name'=>"Nando's West Bromwich",
          'place_address_1'=>"Unit 5A New Square",
          'place_address_2'=>"Walsall St",
          'place_address_area' => " West Bromwich",
          'place_address_city' => "Birmingham",
          'place_address_county' => "West Midlands",
          'place_address_postcode' => "B70 7PP",
          'place_location_lat' => "52.5194293",
          'place_location_lng' => "-1.9914767999999867"
        ],
        [
          'place_id_hash'=> sha1(uniqid("Wednesbury").strtotime("now")),
          'place_name'=>"Nando's Wednesbury - Junction 9",
          'place_address_1'=>"Axletree Way Unit 1",
          'place_address_2'=>"Gallagher Retail Park",
          'place_address_area' => "Wednesbury",
          'place_address_city' => "Birmingham",
          'place_address_county' => "West Midlands",
          'place_address_postcode' => "WS10 9QY",
          'place_location_lat' => "52.5661925",
          'place_location_lng' => "-2.008040400000027"
        ],
        [
          'place_id_hash'=> sha1(uniqid("Walsall").strtotime("now")),
          'place_name'=>"Nando's Walsall",
          'place_address_1'=>"Wolverhampton St",
          'place_address_2'=>"Crown Wharf Shopping Park",
          'place_address_area' => "Walsall",
          'place_address_city' => "Birmingham",
          'place_address_county' => "West Midlands",
          'place_address_postcode' => "WS2 8LR",
          'place_location_lat' => "52.58642219999999",
          'place_location_lng' => "-1.9886090999999624"
        ],
      ]);
  }
}
