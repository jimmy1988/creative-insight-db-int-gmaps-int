<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    //Table Name
    protected $table = 'places';
    //Primary Key
    public $primaryKey = 'place_id';
    //Timestamps
    public $timestamps = false;

    protected $guard = "admin";

    use Notifiable;

    protected $fillable = [
      'place_id_hash',
      'place_name',
      'place_address_1',
      'place_address_city',
      'place_address_county',
      'place_address_postcode',
      'place_location_lat',
      'place_location_lng'
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
    'place_status' => "integer",
    'place_date_last_updated' => "dateTime",
    'place_date_created' => "dateTime",
    'place_date_deleted' => "dateTime"
  ];

  public function placeStatus(){
    return $this->hasOne('App\PlaceStatus', 'place_status_id', 'place_status');
  }
}
