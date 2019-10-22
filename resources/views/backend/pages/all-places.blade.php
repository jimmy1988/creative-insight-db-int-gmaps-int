@extends('backend.templates.admin')

@section('content')

  @include('backend.layouts.titlebar')
  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <div id="all-users-table-container" class="table-responsive">
          <table class="table table-striped table-hover table-condensed">
            <thead>
              <tr>
                <th style="width:2%;">&nbsp;</th>
                <th>Place Name</th>
                <th style="width:30%;">Place Address</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Status</th>
                <th>Date Added</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($allPlaces) && !empty($allPlaces) && $allPlaces->count() > 0)
                @foreach ($allPlaces as $place => $details)

                  <?php
                    $placeStatusClass = "";
                    $placeStatusIcon = "";

                    switch ($details->place_status) {
                      case "1":
                        $placeStatusClass = "success";
                        $placeStatusIcon = "<i class=\"fas fa-check\" title=\"" . $details->placeStatus->place_status . "\"></i>";
                        break;
                      case "2":
                        $placeStatusClass = "warning";
                        $placeStatusIcon = "<i class=\"fas fa-ban\" title=\"" . $details->placeStatus->place_status . "\"></i>";
                        break;
                      case "3":
                        $placeStatusClass = "danger";
                        $placeStatusIcon = "<i class=\"fas fa-times\" title=\"" . $details->placeStatus->place_status . "\"></i>";
                        break;
                      default:
                        $placeStatusClass = "";
                        $placeStatusIcon = "";
                        break;
                    }
                  ?>

                  <?php
                    $placeAddress = "";
                    if($details->place_address_1){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_1;
                      }else{
                        $placeAddress = $details->place_address_1;
                      }
                    }

                    if($details->place_address_2){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_2;
                      }else{
                        $placeAddress = $details->place_address_2;
                      }
                    }

                    if($details->place_address_3){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_3;
                      }else{
                        $placeAddress = $details->place_address_3;
                      }
                    }

                    if($details->place_address_area){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_area;
                      }else{
                        $placeAddress = $details->place_address_area;
                      }
                    }

                    if($details->place_address_city){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_city;
                      }else{
                        $placeAddress = $details->place_address_city;
                      }
                    }

                    if($details->place_address_county){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_county;
                      }else{
                        $placeAddress = $details->place_address_county;
                      }
                    }

                    if($details->place_address_postcode){
                      if(isset($placeAddress) && !empty($placeAddress)){
                        $placeAddress .= ", " . $details->place_address_postcode;
                      }else{
                        $placeAddress = $details->place_address_postcode;
                      }
                    }
                  ?>

                  <tr class="{{ $placeStatusClass }}">
                    <td style="width:2%;">&nbsp;</td>
                    <td>{{ $details->place_name }}</td>
                    <td>{{ $placeAddress }}</td>
                    <td>{{ $details->place_location_lat }}</td>
                    <td>{{ $details->place_location_lng }}</td>
                    <td>{!! $placeStatusIcon !!}</td>
                    <td>{{ date("d-m-Y H:i:s", strtotime($details->place_date_created)) }}</td>
                    <td>
                      <a href="{{ route('admin.place.edit.showForm', $details->place_id_hash) }}" class="btn btn-success btn-edit-custom">
                        <i class="fas fa-user-edit"></i>
                      </a>
                      @if ($details->place_status != "3")
                        <form action="{{route('admin.place.delete', ["soft", $details->place_id_hash])}}" method="post" class="delete-form">
                          @csrf
                          <input type="hidden" name="_method" value="delete" />
                          <button type="submit" class="btn btn-danger btn-edit-custom">
                            <i class="fas fa-times"></i>
                          </button>
                        </form>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6" class="text-center">No Places Found</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
