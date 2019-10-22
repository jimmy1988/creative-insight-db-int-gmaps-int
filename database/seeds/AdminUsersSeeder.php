<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

      DB::table('admin_users')->insert([
        'user_id_hash' => sha1(uniqid("superuser").strtotime("now")),
        'user_email' => "james.mchugh.webdeveloper@gmail.com",
        'user_email_verify_token' => sha1(uniqid('james.mchugh.webdeveloper@gmail.com', true) . strtotime("now")),
        'user_email_verified_at' => date("Y-m-d H:i:s"),
        'user_password' => Hash::make("letmein123"),
        'user_first_name' => "Superuser",
        'user_surname' => "Admin",
        'user_status'=> "2",
        'user_allow_delete' => "no"
        ]);

    }
}
