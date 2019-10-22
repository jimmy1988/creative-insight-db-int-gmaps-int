<?php

namespace App\Http\Controllers;

use App\AdminUsers;
use App\Places;
use App\UserStatus;
use App\PlaceStatus;
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
          $userStatuses = UserStatus::all();

          $data = array(
            "pageTitle" => "Edit User",
            "thisUser" => $thisUser,
            "userToEdit" => $userToEdit->toArray(),
            "userStatuses" => $userStatuses
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

          if(isset($request->user_status) && !empty($request->user_status)){
            if($request->user_status == "5"){
              $userToEdit->user_date_deleted = date("Y-m-d H:i:s");
            }else{
              $userToEdit->user_date_deleted = null;
            }
            $userToEdit->user_status = $request->user_status;
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

    public function deleteUser(Request $request, $deleteMethod = null, $userIDHash = null){
      if(isset($userIDHash) && !empty($userIDHash)){

        if(isset($deleteMethod) && !empty($deleteMethod)){
          $userToDelete = AdminUsers::where('user_id_hash', $userIDHash)->first();

          if(strtolower($deleteMethod) == "soft"){
            $userToDelete->user_status = "5";
            $userToDelete->user_date_deleted = date("Y-m-d H:i:s");
            $userToDelete->save();

            $data = array(
              "messages" => array(
                "success" => array("User deleted successfully"),
                "errors" => array()
              )
            );
            return redirect()->route('admin.users')->with($data);
          }elseif(strtolower($deleteMethod) == "hard"){
            $userToDelete->delete();

            $data = array(
              "messages" => array(
                "success" => array("User deleted successfully"),
                "errors" => array()
              )
            );
            return redirect()->route('admin.users.deleted')->with($data);
          }else{
            $data = array(
              "messages" => array(
                "success" => array(),
                "errors" => array("An invalid delete method was supplied, please try again")
              )
            );
            return redirect()->route('admin.users')->with($data);
          }
        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("A delete method was not specified, please try again")
            )
          );
          return redirect()->route('admin.users')->with($data);
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

    public function deletedUsers(){
      $deletedUsers = AdminUsers::where('user_status', "5")->orderBy('user_id', 'ASC')->get();

      $data = array(
        "pageTitle" => "Deleted Users",
        "thisUser" => parent::currentUserDetails(),
        "deletedUsers" => $deletedUsers
      );

      return view('backend.pages.deleted-users')->with($data);
    }


    public function allPlaces(){
      $thisUser = parent::currentUserDetails();
      $allPlacesActive = Places::whereIn('place_status', ["1"])->orderBy('place_status', 'ASC')->orderBy('place_id', 'ASC')->get();
      $allPlacesNotActive = Places::whereIn('place_status', ['2', '3'])->orderBy('place_status', 'ASC')->orderBy('place_id', 'ASC')->get();
      $allPlaces = $allPlacesActive->merge($allPlacesNotActive);
      $data = array(
        "pageTitle" => "All Places",
        "thisUser" => $thisUser,
        "allPlaces" => $allPlaces
      );

      return view("backend.pages.all-places")->with($data);
    }

    public function showAddPlaceForm(){
      $thisUser = parent::currentUserDetails();
      $placeStatuses = PlaceStatus::all()->toArray();

      $data = array(
        "pageTitle" => "Add Place",
        "thisUser" => $thisUser,
        "placeStatuses" => $placeStatuses
      );

      return view("backend.pages.add-place")->with($data);
    }

    public function createPlace(Request $request){
      $messages = array(
        'place_name.required' => "Fill in the place name",
        'place_address_1.required' => "Please fill in the first line of the address",
        'place_address_city.required' => "Please fill in the address ccity",
        'place_address_county.required' => "Please fill in the address county",
        'place_address_postcode.required' => "Please fill in the address postcode",
        'place_location_lat.required' => "Please fill in the Latitude",
        'place_location_lat.required' => "Please fill in the Longitude"
      );

      $rules = array(
        'place_name' => "required|max:255",
        'place_address_1' => 'required|max:255',
        'place_address_city' => 'required|max:255',
        'place_address_county' => 'required|max:255',
        'place_address_postcode' => 'required|max:255',
        'place_location_lat' => 'required',
        'place_location_lng' => 'required'
      );

      $validatedData = $request->validate($rules, $messages);

      if($request->place_status <= "0"){
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("Please provide a valid place status")
          )
        );
        return redirect()->route('admin.place.add.showForm')->with($data);
      }else{

        $newPlace = array();

        $newPlace['place_id_hash'] = sha1(uniqid($request->place_address_city).strtotime("now"));
        $newPlace['place_name'] = $request->place_name;
        $newPlace['place_address_1'] = $request->place_address_1;
        $newPlace['place_address_city'] = $request->place_address_city;
        $newPlace['place_address_county'] = $request->place_address_county;
        $newPlace['place_address_postcode'] = $request->place_address_postcode;
        $newPlace['place_location_lat'] = $request->place_location_lat;
        $newPlace['place_location_lng'] = $request->place_location_lng;
        $newPlace['place_status'] = $request->place_status;

        if(isset($request->place_address_2) && !empty($request->place_address_2)){
          $newPlace['place_address_2'] = $request->place_address_2;
        }

        if(isset($request->place_address_3) && !empty($request->place_address_3)){
          $newPlace['place_address_3'] = $request->place_address_3;
        }

        if(isset($request->place_address_area) && !empty($request->place_address_area)){
          $newPlace['place_address_area'] = $request->place_address_area;
        }

        Places::create($newPlace);

        $data = array(
          "messages" => array(
            "success" => array("Place Added successfully"),
            "errors" => array()
          )
        );
        return redirect()->route('admin.places')->with($data);
      }

    }

    public function showEditPlaceForm(Request $request, $placeIDHash = null){
      $thisUser = parent::currentUserDetails();
      $placeToEdit = Places::where('place_id_hash', $placeIDHash)->first();
      $placeStatuses = PlaceStatus::all()->toArray();

      $data = array(
        "pageTitle" => "Edit Place",
        "thisUser" => $thisUser,
        "placeStatuses" => $placeStatuses,
        "placeToEdit" => $placeToEdit
      );

      return view("backend.pages.edit-place")->with($data);
    }

    public function updatePlace(Request $request){

      $messages = array(
        'place_id.required' => "An invalid id has been submitted, please try again",
        'place_name.required' => "Fill in the place name",
        'place_address_1.required' => "Please fill in the first line of the address",
        'place_address_city.required' => "Please fill in the address ccity",
        'place_address_county.required' => "Please fill in the address county",
        'place_address_postcode.required' => "Please fill in the address postcode",
        'place_location_lat.required' => "Please fill in the Latitude",
        'place_location_lat.required' => "Please fill in the Longitude",
        'place_status.required' => "Please fill in the status",
      );

      $rules = array(
        'place_id' => "required",
        'place_name' => "required|max:255",
        'place_address_1' => 'required|max:255',
        'place_address_city' => 'required|max:255',
        'place_address_county' => 'required|max:255',
        'place_address_postcode' => 'required|max:255',
        'place_location_lat' => 'required',
        'place_location_lng' => 'required',
        'place_status' => 'required'
      );

      $validatedData = $request->validate($rules, $messages);

      if($request->place_status <= "0"){
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("Please provide a valid place status")
          )
        );
        return redirect()->route('admin.place.edit.showForm', [$request->place_id])->with($data);
      }else{
        $placeToEdit = Places::where('place_id_hash', $request->place_id)->first();

        if(!empty($placeToEdit) && $placeToEdit->count() > 0){

          $placeToEdit->place_name = $request->place_name;
          $placeToEdit->place_address_1 = $request->place_address_1;
          $placeToEdit->place_address_city = $request->place_address_city;
          $placeToEdit->place_address_county = $request->place_address_county;
          $placeToEdit->place_address_postcode = $request->place_address_postcode;
          $placeToEdit->place_location_lat = $request->place_location_lat;
          $placeToEdit->place_location_lng = $request->place_location_lng;
          $placeToEdit->place_status = $request->place_status;

          if(isset($request->place_address_2) && !empty($request->place_address_2)){
            $placeToEdit->place_address_2 = $request->place_address_2;
          }

          if(isset($request->place_address_3) && !empty($request->place_address_3)){
            $placeToEdit->place_address_3 = $request->place_address_3;
          }

          if(isset($request->place_address_area) && !empty($request->place_address_area)){
            $placeToEdit->place_address_area = $request->place_address_area;
          }

          $placeToEdit->save();

          $data = array(
            "messages" => array(
              "success" => array("Place updated successfully"),
              "errors" => array()
            )
          );
          return redirect()->route('admin.place.edit.showForm', [$request->place_id])->with($data);
        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("No place details found with those details, please try again")
            )
          );
          return redirect()->route('admin.place.edit.showForm', [$request->place_id])->with($data);
        }
      }

    }

    public function deletedPlaces(){
      $thisUser = parent::currentUserDetails();
      $deletedPlaces = Places::where("place_status", "3")->orderBy("place_id", "ASC")->get();

      $data = array(
        "pageTitle" => "Deleted Places",
        "thisUser" => $thisUser,
        "deletedPlaces" => $deletedPlaces
      );

      return view("backend.pages.deleted-places")->with($data);
    }

    public function deletePlace(Request $request, $deleteMethod = null, $placeIDHash = null){

      if(isset($placeIDHash) && !empty($placeIDHash)){

        if(isset($deleteMethod) && !empty($deleteMethod)){
          $placeToDelete = Places::where('place_id_hash', $placeIDHash)->first();

          if(strtolower($deleteMethod) == "soft"){
            $placeToDelete->place_status = "3";
            $placeToDelete->place_date_deleted = date("Y-m-d H:i:s");
            $placeToDelete->save();

            $data = array(
              "messages" => array(
                "success" => array("Place deleted successfully"),
                "errors" => array()
              )
            );
            return redirect()->route('admin.places')->with($data);
          }elseif(strtolower($deleteMethod) == "hard"){
            $placeToDelete->delete();

            $data = array(
              "messages" => array(
                "success" => array("Place deleted successfully"),
                "errors" => array()
              )
            );
            return redirect()->route('admin.places.deleted')->with($data);
          }else{
            $data = array(
              "messages" => array(
                "success" => array(),
                "errors" => array("An invalid delete method was supplied, please try again")
              )
            );
            return redirect()->route('admin.places')->with($data);
          }
        }else{
          $data = array(
            "messages" => array(
              "success" => array(),
              "errors" => array("A delete method was not specified, please try again")
            )
          );
          return redirect()->route('admin.places')->with($data);
        }

      }else{
        $data = array(
          "messages" => array(
            "success" => array(),
            "errors" => array("No place found with those details, please try again")
          )
        );
        return redirect()->route('admin.places')->with($data);
      }
    }

}
