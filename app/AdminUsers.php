<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUsers extends Authenticatable
{
    //Table Name
    protected $table = 'admin_users';
    //Primary Key
    public $primaryKey = 'user_id';
    //Timestamps
    public $timestamps = false;

    protected $guard = "admin";

    use Notifiable;

    public function getAuthPassword()
 {
     return $this->user_password;
 }

 protected $fillable = [
   'user_id_hash',
   'user_email',
   'user_email_verify_token',
   'user_password',
   'user_first_name',
   'user_surname',
   'user_status',
 ];

 /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
 protected $hidden = [
   'user_email_verify_token',
   'user_password',
   'password_reset_token',
   'remember_token'
 ];

 /**
  * The attributes that should be cast to native types.
  *
  * @var array
  */
 protected $casts = [
   'user_id' => "integer",
   'email_verified_at' => "datetime",
   'password_reset_token_last_sent' => "datetime",
   'password_last_reset' => "datetime",
   'date_password_last_updated' => "datetime",
   'user_status' => "integer"
 ];
}
