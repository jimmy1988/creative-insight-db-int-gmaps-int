<?php

namespace App\Http\Controllers\Auth\Backend;

use App\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackendVerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function verifyUser(Request $request, $userIDHash = null, $userEmailVerificationToken = null){
      if(isset($userIDHash) && !empty($userIDHash) && isset($userEmailVerificationToken) && !empty($userEmailVerificationToken)){
        $thisUser = AdminUsers::where('user_id_hash', $userIDHash)->where('user_email_verify_token', $userEmailVerificationToken)->first();

        if(!empty($thisUser) && $thisUser->count() > 0){
          $thisUser->user_status = "3";
          $thisUser->user_email_verified_at = date("Y-m-d H:i:s");
          $thisUser->save();

          if(Auth::loginUsingId($thisUser->user_id)){
            $data = array(
              "messages" => array(
                "success" => array("You are registered and verfied to use this system"),
                "errors" => array()
              ),
            );

            return redirect()->route("admin.index")->with($data);
          }else{

            $data = array(
              "messages" => array(
                "success" => array(),
                "errors" => array("You are registered and verfied to use this system but logon failed")
              ),
            );

            return redirect()->route("admin.login")->with($data);
          }
        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("No user found with those credentials, please try again")
            ),
          );

          return redirect()->route('admin.login')->with($data);
        }

      }else{
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("An invalid request was submitted, please try again")
          ),
        );

        return redirect()->route('admin.login')->with($data);

      }

    }
}
