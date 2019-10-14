<?php

namespace App\Http\Controllers;

use App\AdminUsers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $data = array();

    public function __construct(){

    }

    protected static function currentUserDetails(){
      return Auth::guard('admin')->user()->toArray();
    }

    protected static function userIsAllowed($useridhash = null, $userLevel = 7){
      //if user id is not set user the current user
      if(isset($useridhash) && !empty($useridhash)){
        $userid = Auth::guard('admin')->user()->user_id_hash;
      }

      //if user level is less than 1 then set it to 8 - which is the basic user - this is a fallback for incorrect values
      if(isset($userLevel) && !empty($userLevel) && $userid <= 0){
        $userLevel = 8;
      }

      $user = AdminUsers::where("user_id_hash", $useridhash)->first();

      if(isset($user) && !empty($user) && $user->count() > 0){
        if(isset($user->user_level) && !empty($user->user_level) && $user->user_level <= $userLevel){
          return true;
        }else{
          return false;
        }
      }else{
        return false;
      }
    }
}
