@extends('backend.templates.admin')

@section('content')
  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 auth-container">

        <div class="card auth-card">
          <form action="{{route('admin.place.update')}}" method="post">
            @csrf
            <input type="hidden" name="place_id" value="@if (isset($placeToEdit->place_id_hash) && !empty($placeToEdit->place_id_hash)) {{$placeToEdit->place_id_hash}} @else {{"0"}} @endif" />
            <div class="card-header text-center">
              <div class="login-logo">
                <a href="/">
                  <img alt="Project Logo" src="/images/logo.png" class="auth-logo"/>
                </a>
              </div>
            </div>
            <div class="card-body auth-body">
              <div class="login-box auth-box">
                <div class="login-box-body auth-box-body">
                  <h4 class="text-center auth-title">@if (isset($pageTitle) && !empty($pageTitle)) {{ $pageTitle }} @else {{ "Register" }} @endif</h4>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place Name (Required)" name="place_name" id="place_name" value="@if (isset($placeToEdit->place_name) && !empty($placeToEdit->place_name)) {{$placeToEdit->place_name}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-signature"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Address 1 (Required)" name="place_address_1" id="place_address_1" value="@if (isset($placeToEdit->place_address_1) && !empty($placeToEdit->place_address_1)) {{$placeToEdit->place_address_1}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Address 2" name="place_address_2" id="place_address_2" value="@if (isset($placeToEdit->place_address_2) && !empty($placeToEdit->place_address_2)) {{$placeToEdit->place_address_2}} @endif">
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Address 3" name="place_address_3" id="place_address_3" value="@if (isset($placeToEdit->place_address_3) && !empty($placeToEdit->place_address_3)) {{$placeToEdit->place_address_3}} @endif">
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place Area" name="place_address_area" id="place_address_area" value="@if (isset($placeToEdit->place_address_area) && !empty($placeToEdit->place_address_area)) {{$placeToEdit->place_address_area}} @endif">
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place City (Required)" name="place_address_city" id="place_address_city" value="@if (isset($placeToEdit->place_address_city) && !empty($placeToEdit->place_address_city)) {{$placeToEdit->place_address_city}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place County (Required)" name="place_address_county" id="place_address_county" value="@if (isset($placeToEdit->place_address_county) && !empty($placeToEdit->place_address_county)) {{$placeToEdit->place_address_county}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place Postcode (Required)" name="place_address_postcode" id="place_address_postcode" value="@if (isset($placeToEdit->place_address_postcode) && !empty($placeToEdit->place_address_postcode)) {{$placeToEdit->place_address_postcode}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Latitude (Required)" name="place_location_lat" id="place_location_lat" value="@if (isset($placeToEdit->place_location_lat) && !empty($placeToEdit->place_location_lat)) {{$placeToEdit->place_location_lat}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-crosshairs"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Longitude (Required)" name="place_location_lng" id="place_location_lng" value="@if (isset($placeToEdit->place_location_lng) && !empty($placeToEdit->place_location_lng)) {{$placeToEdit->place_location_lng}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-crosshairs"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <select class="form-control" name="place_status" id="place_status">
                      <option value="-1">Place Status (Required)</option>
                      @if (isset($placeStatuses) && !empty($placeStatuses))
                        @for ($i=0; $i < count($placeStatuses); $i++)
                          <option value="{{$placeStatuses[$i]['place_status_id']}}"
                          @if (isset($placeToEdit->place_status) && !empty($placeToEdit->place_status) && isset($placeStatuses[$i]['place_status_id']) && !empty($placeStatuses[$i]['place_status_id']) && $placeToEdit->place_status == $placeStatuses[$i]['place_status_id'])
                            {{"selected"}}
                          @endif
                          >{{$placeStatuses[$i]['place_status']}}</option>
                        @endfor
                      @endif
                    </select>
                  </div>

                  <div class="clearfix"></div>
                </div>
                <!-- /.login-box-body -->
              </div>
              <!-- /.login-box -->
            </div>
            <div class="card-footer text-right auth-footer">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Edit Place</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('backend.includes.auth-password-reveal')
  <script type="text/javascript" src="/js/password-generator.js"></script>
@endsection
