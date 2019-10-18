<?php

namespace App\Http\Controllers\Auth\Backend;

use App\AdminUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;

class BackendRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    //Overrides

    public function showRegistrationForm(){
      $thisUser = parent::currentUserDetails();
      $data = array(
        "pageTitle" => "Register New User",
        "thisUser" => $thisUser
      );
      return view('backend.pages.auth.register')->with($data);
    }

    public function register(Request $request){

      $messages = array(
        'user_first_name.required' => "Fill in your first name",
        'user_surname.required' => "Fill in your surname",
        'user_email.unique' => "Email Address already exists",
        'user_email.required' => "Please fill in your email address",
        'user_email.email' => "Email Address is not in a valid format",
        'user_password.required' => "Please provide a password",
        'user_password_confirm.required' => "Please confirm your password",
        'user_password_confirm.same:user_password' => "The passwords does not match",
      );

      $rules = array(
        'user_first_name' => "required|max:255",
        'user_surname' => "required|max:255",
        'user_email' => 'required|email|unique:admin_users,user_email',
        'user_password' => 'required|same:user_password_confirm',
        'user_password_confirm' => 'required|same:user_password',
      );

      $validatedData = $request->validate($rules, $messages);

      $requestData = $request->all();

      $userEmailVerificationToken = sha1(uniqid($requestData['user_email'], true) . strtotime("now"));
      $userIDHash = sha1(uniqid($requestData['user_surname']).strtotime("now"));

      $user =  AdminUsers::create([
           'user_id_hash' => $userIDHash,
           'user_email' => $requestData['user_email'],
           'user_email_verify_token' => $userEmailVerificationToken,
           'user_password' => Hash::make($requestData['user_password']),
           'user_first_name' => $requestData['user_first_name'],
           'user_surname' => $requestData['user_surname'],
           'user_status' => '1',
       ]);

       \Mail::to($user->user_email)->send(new \App\Mail\Admin\sendEmails($user, "backend.emails.verifyEmail", "Cative Insight Developer Test Admin: Email Verification Required"));

       $data = array(
         "messages" => array(
           "success" => array("User Created Successfully, Pleasee ask them to check their emails for an email to verify their account"),
           "errors" => array()
         )
       );

       return redirect()->route('admin.index')->with($data);
    }
}
