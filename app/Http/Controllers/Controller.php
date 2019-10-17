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
      return Auth::user()->toArray();
    }
}
