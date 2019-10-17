<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPagesController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $redirectTo = '/admin/login';

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:admin');

    }

    protected function guard()
    {
        return Auth::guard('admin');
    }


    public function index(){
      $thisUser = parent::currentUserDetails();
      $data = array(
        "pageTitle" => "Dashboard",
        "thisUser" => $thisUser
      );

      return view("backend.pages.dash")->with($data);
    }
}
