<?php

namespace App\Http\Controllers\Auth\Backend;

use App\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BackendLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    private function isEmailVerified($thisUser){
        $errors=array();
        if(
          (!isset($thisUser->user_email_verify_token) || empty($thisUser->user_email_verify_token) || $thisUser->user_email_verify_token == "") ||
          (!isset($thisUser->user_email_verified_at) || empty($thisUser->user_email_verified_at) || $thisUser->user_email_verified_at == "0000-00-00 00:00:00" || strtotime($thisUser->user_email_verified_at) > strtotime(date("Y-m-d H:i:s")))
        ){
          array_push($errors, "Your account has not been verified yet, please click on the link in the email we have sent you to verify your email address and activate your user account");
          return $errors;
        }else{
          return false;
        }

    }

    private function getUserStatusMessage($thisUser){
      $errors=array();
      if(isset($thisUser->user_status) && !empty($thisUser->user_status) && $thisUser->user_status > 0){
        switch($thisUser->user_status){
          case 1:
            array_push($errors, "Your account is waiting confirmation, please check your emails and click on the link");
          break;
          case 4:
            array_push($errors, "Your account is banned, please contact the site administrator for assistance");
            break;
          case 5:
            array_push($errors, "Your account is deleted, please contact the site administrator for assistance");
            break;
          default:
            break;
        }
      }else{
        array_push($errors, "No account status can be found for you, please contact the site administrator for further assistance");
      }

      return $errors;
    }

    //Overrides
    public function showLoginForm(){
      $data = array(
        "pageTitle" => "Login"
      );

      return view("backend.pages.auth.login")->with($data);
    }

    public function login(Request $request){

      $messages = array(
        'user_email.required' => "Please fill in your email address",
        'user_password.required' => "Please provide a password",
      );

      $rules = array(
        'user_email' => 'required',
        'user_password' => 'required'
      );

      $validatedData = $request->validate($rules, $messages);

      $requestData = $request->all();

      if(isset($requestData['rememberMe']) && !empty($requestData['rememberMe']) && $requestData['rememberMe'] == "on"){
        $remember = true;
      }else{
        $remember = false;
      }

      DB::enableQueryLog();

      $thisAdminUser = AdminUsers::where('user_email', $requestData['user_email'])
                                ->where(function($query){
                                  $query->where('user_status', "=", 2)
                                      ->orWhere('user_status', "=", 3);
                                })
                                ->where(function($query){
                                  $query->whereNotNull('user_email_verify_token')
                                  ->where('user_email_verify_token', "!=", '');
                                })
                                ->where(function($query){
                                  $query  ->whereNotNull('user_email_verified_at')
                                    ->where('user_email_verified_at', "!=", "")
                                    ->where('user_email_verified_at', "!=", "0000-00-00 00:00:00")
                                    ->where('user_email_verified_at', '<=', date("Y-m-d H:i:s"));
                                })
                                ->first();

      if(!empty($thisAdminUser) && $thisAdminUser->count() > 0){
        $userid = Auth::attempt(['user_id_hash' => $thisAdminUser->user_id_hash, 'password' => $requestData['user_password']], $remember);
        if($userid > 0){
          $thisAdminUser->user_status = "3";
          $thisAdminUser->save();
          return redirect()->route('admin.index');
        }else{
          $errors = array("Email or Password Incorrect");
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => $errors
            ),
            "user_email" => $requestData['user_email']
          );
          return redirect()->route('admin.login')->with($data);
        }
      }else{

        $thisAdminUser = AdminUsers::where('user_email', $requestData['user_email'])->first();

        $data = array();

        if(!empty($thisAdminUser) && $thisAdminUser->count() > 0){

          if($errors = $this->isEmailVerified($thisAdminUser)){
            $data = array(
              "messages" => array(
                "success" => array(),
                "errors" => $errors
              ),
              "user_email" => $requestData['user_email']
            );
          }elseif($errors = $this->getUserStatusMessage($thisAdminUser)){
            $data = array(
              "messages" => array(
                "success" => array(),
                "errors" => $errors
              ),
              "user_email" => $requestData['user_email']
            );
          }

        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("No user is found with those credentials")
            ),
            "user_email" => $requestData['user_email']
          );
        }

        return redirect()->route('admin.login')->with($data);
      }
    }

    public function logout(Request $request){
      $user_id = Auth::id();
      $thisAdminUser = AdminUsers::where('user_id', $user_id)->first();
      if(!empty($thisAdminUser) && $thisAdminUser->count() > 0){
        $thisAdminUser->user_status = "2";
        $thisAdminUser->remember_token = null;
        $thisAdminUser->save();
        Auth::logout();
        return redirect()->route('admin.login.showLoginForm');
      }else{
        return redirect()->route('admin.index');
      }
    }
}
