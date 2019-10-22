<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminUsersSeeder::class);
        $this->call(PlacesSeeder::class);
        $this->call(UserStatusSeeder::class);
        $this->call(PlaceStatusSeeder::class);
    }
}
