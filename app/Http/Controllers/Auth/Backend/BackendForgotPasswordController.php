<?php

namespace App\Http\Controllers\Auth\Backend;

use App\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //Overrides

    public function sendResetLinkEmail(Request $request){
      $messages = [
        'user_email.required' => "Please fill in your email address"
      ];

      $validatedData = $request->validate([
        'user_email' => 'required'
      ], $messages);

      $data = $request->all();

      $user = AdminUsers::where("user_email", $data['user_email'])->first();

      if($user->count() > 0){
        $user->user_password_reset_token=sha1(uniqid($data['user_email'], true) . $user->user_surname . strtotime("now"));;
        $user->save();

        \Mail::to($user->user_email)->send(new \App\Mail\Admin\sendEmails($user, "backend.emails.resetPassword", "Creative Insight Developer Test Admin: Reset Your Password"));

        $data = array(
          "messages" => array(
            "success" => array("An email has been sent to you to reset, your password, please click on the link that is provided"),
            "errors" => array()
          ),
        );

        Auth::logout();
        return redirect()->route('admin.login')->with($data);
      }
    }

    public function showLinkRequestForm(){
      $data = array(
        "pageTitle" => "Request Password Reset"
      );

      return view("backend.pages.auth.passwords.email")->with($data);
    }
}
