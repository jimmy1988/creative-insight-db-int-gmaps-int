<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        // $this->middleware('auth:admin');

    }

    protected function guard()
    {
        return Auth::guard('admin');
    }


    public function index(){
      $data = array(

      );

      return view("backend.pages.dash")->with($data);
    }
}
