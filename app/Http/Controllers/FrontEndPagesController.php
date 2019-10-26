<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Places;

class FrontEndPagesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
      parent::__construct();
      // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){

      $this->data['menuIsSticky'] = true;

      return view('frontend.pages.index')->with($this->data);
    }

    public function searchForPlaces(Request $request, $searchTerm = null, $currentLat = null, $currentLng = null, $distanceMiles = 0){
      if(isset($searchTerm) && !empty($searchTerm)){
        $searchTerm = "%" . $searchTerm . "%";
        $searchResults = Places::distinct()
                        ->where('place_name', 'LIKE', $searchTerm)
                        ->orWhere('place_address_1', 'LIKE', $searchTerm)
                        ->orWhere('place_address_2', 'LIKE', $searchTerm)
                        ->orWhere('place_address_3', 'LIKE', $searchTerm)
                        ->orWhere('place_address_area', 'LIKE', $searchTerm)
                        ->orWhere('place_address_city', 'LIKE', $searchTerm)
                        ->orWhere('place_address_county', 'LIKE', $searchTerm)
                        ->orWhere('place_address_postcode', 'LIKE', $searchTerm)
                        ->orderBy('place_id', 'ASC')
                        ->get();

        if(!empty($searchResults) && $searchResults->count() > 0) {

          if(isset($currentLat) && !empty($currentLat) && isset($currentLng) && !empty($currentLng) && isset($distanceMiles)){

            $searchResultsArray = $searchResults->toArray();

            $finalSearchResultsArray = array();

            for($i=0; $i < count($searchResultsArray); $i++){

              $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins=" . $currentLat . "," . $currentLng. "&destinations=" . $searchResultsArray[$i]['place_location_lat'] . "," . $searchResultsArray[$i]['place_location_lng'] . "&key=" . Config::get('constants.options.googleMapsAPIKey');
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
              curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
              curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
              $response = curl_exec($ch);
              curl_close($ch);
              $response_a = json_decode($response, true);
              $chDistanceMiles = (float) $response_a['rows'][0]['elements'][0]['distance']['text'];
              if(isset($chDistanceMiles) && !empty($chDistanceMiles) && $chDistanceMiles >= 0 && $chDistanceMiles <= ($distanceMiles + 5)){
                $searchResultsArray[$i]['distance'] = $chDistanceMiles;
                array_push($finalSearchResultsArray, $searchResultsArray[$i]);
              }
            }

            $keys = array_column($finalSearchResultsArray, 'distance');
            array_multisort($keys, SORT_ASC, $finalSearchResultsArray);

            return json_encode($finalSearchResultsArray);

          }else{
            return json_encode($searchResults->toArray());
          }
        }else{
          return json_encode(array());
        }
      }else{
        return json_encode(array());
      }
    }
}
