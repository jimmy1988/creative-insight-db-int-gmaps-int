<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->integer('user_id')->autoIncrement();
            $table->string('user_id_hash')->unique();
            $table->string('user_email')->unique();
            $table->string('user_email_verify_token')->unique();
            $table->dateTime('user_email_verified_at')->nullable();
            $table->string('user_password');
            $table->string('user_first_name');
            $table->string('user_surname');
            $table->rememberToken();
            $table->integer('user_status')->default("1");
            $table->dateTime('user_date_last_updated')->nullable();
            $table->dateTime('user_date_created')->useCurrent();
            $table->dateTime('user_date_deleted')->nullable();
            $table->string('user_allow_delete')->default('yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_users');
    }
}
