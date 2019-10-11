<?php

use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('user_status')->insert([
        ['user_status'=> "Awaiting Verification"],
        ['user_status'=> "Active"],
        ['user_status'=> "Banned"],
        ['user_status'=> "Deleted"]
      ]);

    }
}
