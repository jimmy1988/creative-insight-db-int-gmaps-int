<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    //Table Name
    protected $table = 'user_status';
    //Primary Key
    public $primaryKey = 'user_status_id';
    //Timestamps
    public $timestamps = false;

    protected $guard = "admin";

    use Notifiable;

    protected $fillable = [
     'user_status'
    ];

  /**
  * The attributes that should be hidden for arrays.
  *
  * @var array
  */
  protected $hidden = [

  ];

  /**
  * The attributes that should be cast to native types.
  *
  * @var array
  */
  protected $casts = [

  ];

  public function adminUsers(){
    return $this->belongsTon('App\AdminUsers', 'user_status', 'user_status_id');
  }
}
