<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceStatus extends Model
{
    //Table Name
    protected $table = 'place_status';
    //Primary Key
    public $primaryKey = 'place_status_id';
    //Timestamps
    public $timestamps = false;

    protected $guard = "admin";

    use Notifiable;

    protected $fillable = [
     'place_status'
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

  public function placeStatus(){
    return $this->hasOne('App\Places', 'place_status', 'place_status_id');
  }
}
