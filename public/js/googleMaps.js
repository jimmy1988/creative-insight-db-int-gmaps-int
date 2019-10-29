var defaultLat = 52.4786758;
var defaultLong = -1.9001709;
var zoomlevel = 16;
var map;
var infoWindow;
var marker;
var center;
var currentloc = {};
var directionsService;
var directionsRenderer;
var searchTerm;
var distanceMiles;
var currentLat;
var currentLng;
var xhr = null;
var queryString = "";
var markers = [];
var places = [];
var newRequest = false;

function createmarker(place = null){

  var marker = new google.maps.Marker;
  marker.setMap(map);

  marker.setPosition({lat: parseFloat(place.lat), lng: parseFloat(place.lng)});

  return marker;
}

function initializeMap() {
  $("#curtain-outer").show();

  center = new google.maps.LatLng(defaultLat, defaultLong);

  map = new google.maps.Map(document.getElementById('map'), {
    center: center,
    zoom: zoomlevel
  });

  infoWindow = new google.maps.InfoWindow;
  marker = new google.maps.Marker;

  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer();

  // Try HTML5 geolocation.
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      currentloc.lat = parseFloat(position.coords.latitude);
      currentloc.lng = parseFloat(position.coords.longitude);

      $("#current-lat").val(currentloc.lat);
      $("#current-lng").val(currentloc.lng);

      center = new google.maps.LatLng(currentloc.lat, currentloc.lng);

      var icon = {
        url: "https://image.flaticon.com/icons/svg/60/60834.svg",
        scaledSize: new google.maps.Size(30, 30)
      };

      marker.setPosition(center);
      marker.setMap(map);
      marker.setAnimation(google.maps.Animation.BOUNCE);
      marker.setIcon(icon);
      marker.setVisible(true);

      var infowindow = new google.maps.InfoWindow({
        content: "Your Location"
      });
      marker.addListener('click', function(){
        infowindow.open(map, this);
      });

      map.setCenter(center);
    }, function() {
      handleLocationError(true, infoWindow, map.getCenter());
    }, {maximumAge:50, timeout:5000, enableHighAccuracy: true});
  } else {
    currentloc.lat = parseFloat(defaultLat);
    currentloc.lng = parseFloat(defaultLong);

    center = new google.maps.LatLng(currentloc.lat, currentloc.lng);

    var icon = {
      url: "https://image.flaticon.com/icons/svg/60/60834.svg",
      scaledSize: new google.maps.Size(30, 30)
    };

    marker.setPosition(center);
    marker.setMap(map);
    marker.setAnimation(google.maps.Animation.BOUNCE);
    marker.setIcon(icon);
    marker.setVisible(true);

    var infowindow = new google.maps.InfoWindow({
      content: "Your Location"
    });
    marker.addListener('click', function(){
      infowindow.open(map, this);
    });

    map.setCenter(center);
  }

  $("#curtain-outer").fadeOut(500);
}

function displayDirections(route = []){
  var html = "";
  if(route != undefined && route != null && route.length > 0){
    html = html + "<div class=\"card-header text-center\" id=\"rightPaneHeader\">Directions</div>";

    for(var i = 0; i < route.length; i++){
      var stepNumber = i + 1;

      html = html + "<div class=\"container-fluid directions-entry\">";
      html = html + "<div class=\"directions-entry-row\">";
      html = html + "<div class=\"step-number-container text-center\">";
      html = html + "<div class=\"step-number\">" + stepNumber + "</div>";
      html = html + "</div>";
      html = html + "<div class=\"step-instructions-container text-center\">";
      html = html + "<div class=\"step-instructions\">" + route[i].instructions + "</div>";
      html = html + "</div>";
      html = html + "<div class=\"clearfix\"></div>";
      html = html + "</div>";
      html = html + "</div>";
    }
  }

  return html;
}

function getDirections(event, elem, placesArrayIndex = -1){
  event.preventDefault();
  if(placesArrayIndex != undefined && placesArrayIndex != null && placesArrayIndex >= 0){
    var thisPlace = places[placesArrayIndex];

    var distance = google.maps.geometry.spherical.computeDistanceBetween(new google.maps.LatLng(currentloc.lat, currentloc.lng), new google.maps.LatLng(thisPlace.place_location_lat, thisPlace.place_location_lng));
    distance = parseFloat(distance) / parseFloat("1609.344");
    distance = parseFloat(distance.toFixed(1));

    $("#rightPaneContent").html("");

    var home = center;
    var destination = new google.maps.LatLng(thisPlace.place_location_lat, thisPlace.place_location_lng);

    directionsRenderer.setMap(map);

    var request = {
      origin: home,
      destination: destination,
      travelMode: 'DRIVING'
    };

    directionsService.route(request, function(result, status) {
      if (status == 'OK') {
        directionsRenderer.setDirections(result);
        var routeArray = result.routes[0].legs[0].steps
        $("#rightPaneContent").append(displayDirections(routeArray));
      }
    });

    $("#rightPaneContent").show();
    resetSearch(true, true, true, true, false, false);
    $("#mapContainerMain").removeAttr("style");

  }else{
    alert("No location found");
  }
}

function loadXHR(){
   if (window.XMLHttpRequest) {
      xhr = new XMLHttpRequest();
   } else {
     xhr = new ActiveXObject("Microsoft.XMLHTTP");
   }
}

function resetSearch(clearSearchContent = true, hideSearchContent = true, removeResultsClass = true, clearMarkers = true, clearDirections = true, addStyles = true){

  if(clearSearchContent){
    $("#search-results-container").html("");
  }

  if(hideSearchContent){
    $("#search-results-container").hide();
  }

  if(removeResultsClass){
    $("#search-results-container").removeClass("resultsFound");
  }

  if(clearMarkers){
    if(markers.length > 0){
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
        markers.splice(i, 1);
      }
    }
  }

  if(clearDirections){
    directionsRenderer.setMap(null);
  }

  if(addStyles){
    $("#mapContainerMain").css({
      "display":"block",
      "width":"100% !important",
      "max-width":"100%",
      "flex":"unset"
    });
  }
}

function responseXHR(){
  if (xhr.readyState == 4 && xhr.status == 200 && newRequest == false) {
    var responseJSON = JSON.parse(this.responseText);
    var responseJSONCount = Object.keys(responseJSON).length;
    resetSearch();
     if(responseJSONCount > 0 && $("#search-box").val() != ""){

      places = [];
       for(var i = 0; i < responseJSONCount; i++){

         places.push(responseJSON[i])
         var address = "";
         if(responseJSON[i].place_address_1 != null && responseJSON[i].place_address_1 != undefined && responseJSON[i].place_address_1 != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_1;
           }else{
             address = responseJSON[i].place_address_1;
           }
         }

         if(responseJSON[i].place_address_2 != null && responseJSON[i].place_address_2 != undefined && responseJSON[i].place_address_2 != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_2;
           }else{
             address = responseJSON[i].place_address_2;
           }
         }

         if(responseJSON[i].place_address_3 != null && responseJSON[i].place_address_3 != undefined && responseJSON[i].place_address_3 != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_3;
           }else{
             address = responseJSON[i].place_address_3;
           }
         }

         if(responseJSON[i].place_address_area != null && responseJSON[i].place_address_area != undefined && responseJSON[i].place_address_area != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_area;
           }else{
             address = responseJSON[i].place_address_area;
           }
         }

         if(responseJSON[i].place_address_city != null && responseJSON[i].place_address_city != undefined && responseJSON[i].place_address_city != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_city;
           }else{
             address = responseJSON[i].place_address_city;
           }
         }

         if(responseJSON[i].place_address_county != null && responseJSON[i].place_address_county != undefined && responseJSON[i].place_address_county != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_county;
           }else{
             address = responseJSON[i].place_address_county;
           }
         }

         if(responseJSON[i].place_address_postcode != null && responseJSON[i].place_address_postcode != undefined && responseJSON[i].place_address_postcode != ""){
           if(address!= null && address != undefined && address != ""){
             address = address + ", " + responseJSON[i].place_address_postcode;
           }else{
             address = responseJSON[i].place_address_postcode;
           }
         }

         var responseHTML = "";
         responseHTML = responseHTML + "<a href=\"#\" onclick=\"getDirections(event, this," + i + ")\" class=\"container-fluid search-result\">";
         responseHTML = responseHTML + " <div class=\"row\">";
         responseHTML = responseHTML + "   <div class=\"col-xs-9 col-md-9 search-column-1\">";

         if(responseJSON[i].place_name != null && responseJSON[i].place_name  != undefined && responseJSON[i].place_name != ""){
           responseHTML = responseHTML + "     <h4 class=\"text-center search-place-name\">" + responseJSON[i].place_name + "</h4>";
         }

         responseHTML = responseHTML + "     <p class=\"text-center search-place-address\">" + address + "</p>";
         responseHTML = responseHTML + "   </div>";
         responseHTML = responseHTML + "   <div class=\"col-xs-3 col-md-3 text-center search-column-2\">";

         if(responseJSON[i].distance != null && responseJSON[i].distance != undefined && responseJSON[i].distance != ""){
           responseHTML = responseHTML + "      <p>";
           responseHTML = responseHTML + "        <span class=\"miles-amount\">";
           responseHTML = responseHTML + responseJSON[i].distance;
           responseHTML = responseHTML + "        </span>";
           responseHTML = responseHTML + "        <span>Miles</span>";
           responseHTML = responseHTML + "      </p>";
         }

         responseHTML = responseHTML + "   </div>";
         responseHTML = responseHTML + " </div>";
         responseHTML = responseHTML + "</a>";

         $("#search-results-container").append(responseHTML);
         $("#search-results-container").addClass("resultsFound");
         $("#search-results-container").show();

         if(
              responseJSON[i].place_location_lat != null && responseJSON[i].place_location_lat != undefined && responseJSON[i].place_location_lat != "" &&
              responseJSON[i].place_location_lng != null && responseJSON[i].place_location_lng != undefined && responseJSON[i].place_location_lng != ""
          ){
           var currentMarker = createmarker({lat: responseJSON[i].place_location_lat, lng: responseJSON[i].place_location_lng});
           markers.push(currentMarker);
         }


       }

       zoomlevel = 10;
       map.setZoom(zoomlevel);
     }else{
       if($("#search-box").val() != ""){
         var responseHTML = "";
         var responseHTML = "";
         responseHTML = responseHTML + "<div class=\"container-fluid search-result\">";
         responseHTML = responseHTML + " <div class=\"row\">";
         responseHTML = responseHTML + "   <div class=\"col-xs-12 col-md-12 search-column-1\">";
         responseHTML = responseHTML + "   <h4 class=\"text-center search-place-name\">No Places Found</h4>";
         responseHTML = responseHTML + "   </div>";
         responseHTML = responseHTML + " </div>";
         responseHTML = responseHTML + "</div>";
         $("#search-results-container").append(responseHTML);
         $("#search-results-container").show();
       }
     }
  }
}

function searchResults(){
  searchTerm = $("#search-box").val();
  distanceMiles = $("#distance-box").val();
  currentLat = $("#current-lat").val();
  currentLng = $("#current-lng").val();

  if(
    searchTerm != undefined && searchTerm != null && searchTerm != "" &&
    distanceMiles != undefined && distanceMiles != null && distanceMiles != "" &&
    currentLat != undefined && currentLat != null && currentLat != "" &&
    currentLng != undefined && currentLng != null && currentLng != ""
  ){
    newRequest = true;
    $("#search-results-container").html("");
    loadXHR();

    xhr.onreadystatechange = responseXHR;

    queryString = "/" + searchTerm + "/" + currentLat + "/" + currentLng + "/" + distanceMiles;

    xhr.open("GET", ajaxSearchRoute + queryString, true);
    newRequest = false;
    xhr.send();
  }else{
    resetSearch();
  }
}

$(document).ready(function(){
  $("#search-box").on("keyup", searchResults);
  $("#distance-box").on("change", searchResults);
  $("#search-box, #distance-box").on("onblur", function(){
    resetSearch();
  });

  $("#searchForm").on("submit", function(){
    event.preventDefault();
  });
});
