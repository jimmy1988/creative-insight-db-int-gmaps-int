<?php

namespace App\Http\Controllers\Auth\Backend;

use App\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackendResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('guest');
    }

    public function reset(Request $request){

      $messages = array(
        'user_password.required' => "Please provide a password",
      );

      $rules = array(
        'user_password' => 'required'
      );

      $validatedData = $request->validate($rules, $messages);

      $requestData = $request->all();

      $remember = true;

      $thisUser = AdminUsers::where('user_id_hash', $requestData['user_id'])->first();

      if(!empty($thisUser) && $thisUser->count() > 0){
        $thisUser->user_password = Hash::make($requestData['user_password']);
        $thisUser->save();
        $data = array(
          "messages" => array(
            "success" => array("Password changed successfully"),
            "errors" => array()
          )
        );

        Auth::attempt(['user_id_hash' => $thisUser->user_id_hash, 'password' => $requestData['user_password']], $remember);
        return redirect()->route('admin.index')->with($data);
      }else{
        $data = array(
          "messages" => array(
            "success" => array("Password changed successfully"),
            "errors" => array("No user found with those credentials, password was not changed")
          )
        );
        return redirect()->route('admin.login')->with($data);
      }

      print_r($request->all());
      return "ok";
    }

    public function showResetForm(Request $request, $userHash = null, $passwordResetToken = null){

      $requestData = $request->all();

      if(isset($userHash) && !empty($userHash) && isset($passwordResetToken) && !empty($passwordResetToken)){

        $thisUser = AdminUsers::where("user_id_hash", $userHash)->where("user_password_reset_token", $passwordResetToken)->first();

        if(!empty($thisUser) && $thisUser->count() > 0){
          $data = array(
            "pageTitle" => "Reset Password",
            "user_id_hash" => $userHash,
            "password_reset_token" => $passwordResetToken
          );
          return view("backend.pages.auth.passwords.reset")->with($data);
        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("The user and password tokens you have submitted are invalid, please try again")
            )
          );
          return redirect()->route('admin.login')->with($data);
        }
      }else{
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("An invlaid request was submitted, please try again")
          )
        );
        return redirect()->route('admin.login')->with($data);
      }

    }
}
