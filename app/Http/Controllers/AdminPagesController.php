<?php

namespace App\Http\Controllers;

use App\AdminUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function allUsers(){
      $thisUser = parent::currentUserDetails();
      $allUsersActive = AdminUsers::whereIn('user_status', ['2', '3'])->orderBy('user_status', 'DESC')->orderBy('user_id', 'ASC')->get();
      $allUsersNotActive = AdminUsers::whereNotIn('user_status', ['2', '3'])->orderBy('user_status', 'ASC')->orderBy('user_id', 'ASC')->get();
      $allUsers = $allUsersActive->merge($allUsersNotActive);
      $data = array(
        "pageTitle" => "All Users",
        "thisUser" => $thisUser,
        "allUsers" => $allUsers
      );

      return view("backend.pages.all-users")->with($data);
    }

    public function userProfile(){
      $thisUser = parent::currentUserDetails();
      $data = array(
        "pageTitle" => "User Profile",
        "thisUser" => $thisUser,
        "userToEdit" => $thisUser
      );

      return view("backend.pages.edit-user")->with($data);
    }

    public function showEditUserForm(Request $request, $userIDHash = null){
      if(isset($userIDHash) && !empty($userIDHash)){
        $userToEdit = AdminUsers::where('user_id_hash', $userIDHash)->first();
        if(!empty($userToEdit) && $userToEdit->count() > 0 && $userToEdit->user_id != Auth::guard('admin')->id()){
          $thisUser = parent::currentUserDetails();

          $data = array(
            "pageTitle" => "Edit User",
            "thisUser" => $thisUser,
            "userToEdit" => $userToEdit->toArray()
          );

          return view("backend.pages.edit-user")->with($data);
        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("No user details found with those credentails, please try again")
            )
          );
          return redirect()->route('admin.users')->with($data);
        }
      }else{
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("Invalid user credentails submitted, please try again")
          )
        );
        return redirect()->route('admin.users')->with($data);
      }

    }

    public function updateUser(Request $request){
      $messages = array(
        'user_first_name.required' => "Fill in your first name",
        'user_surname.required' => "Fill in your surname",
        'user_email.unique' => "Email Address already exists",
        'user_email.required' => "Please fill in your email address",
        'user_email.email' => "Email Address is not in a valid format",
        'user_password_confirm.same:user_password' => "The passwords does not match",
        'user_id' => "No user id was submitted",
      );

      $rules = array(
        'user_first_name' => "required|max:255",
        'user_surname' => "required|max:255",
        'user_email' => 'required|email',
        'user_password' => 'same:user_password_confirm',
        'user_password_confirm' => 'same:user_password',
        'user_id' => "required"
      );

      $validatedData = $request->validate($rules, $messages);

      $emailExists = AdminUsers::where('user_id_hash', "!=", $request->user_id)->where('user_email', "=", $request->user_email)->get();

      if(!empty($emailExists) && $emailExists->count() > 0){
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("Email address already exists, please try again")
          )
        );
        return redirect()->route('admin.users')->with($data);
      }else{
        $userToEdit = AdminUsers::where('user_id_hash', $request->user_id)->first();

        if(!empty($userToEdit) && $userToEdit->count() > 0){

          if($userToEdit->user_first_name != $request->user_first_name){
            $userToEdit->user_first_name = $request->user_first_name;
          }

          if($userToEdit->user_surname != $request->user_surname){
            $userToEdit->user_surname = $request->user_surname;
          }

          if($userToEdit->user_email != $request->user_email){
            $userToEdit->user_email = $request->user_email;
          }

          if(isset($request->user_password) && !empty($request->user_password)){
            $userToEdit->user_password = Hash::make($request->user_password);
          }


          $userToEdit->save();

          $data = array(
            "messages" => array(
              "success" => array("User updated sucessfully"),
              "errors" => array()
            )
          );

          if($userToEdit->user_id == Auth::guard('admin')->id()){
            return redirect()->route('admin.user.profile')->with($data);
          }else{
            return redirect()->route('admin.user.edit.showForm', $request->user_id)->with($data);
          }


        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("No user details found with those credentails, please try again")
            )
          );
          return redirect()->route('admin.users')->with($data);
        }
      }
    }

    public function deleteUser($method = null, $userIDHash = null){

    }

    public function deletedUsers(){

    }


    public function allPlaces(){

    }

    public function showAddPlaceForm(){

    }

    public function createPlace(){

    }

    public function showEditPlaceForm($placeIDHash = null){

    }

    public function updatePlace(){

    }

    public function deletedPlaces(){

    }

    public function deletePlace($method = null, $placeIDHash = null){

    }

}
