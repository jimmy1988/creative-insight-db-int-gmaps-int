@extends('backend.templates.admin')

@section('content')
  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 auth-container">

        <div class="card auth-card">
          <form action="{{route('admin.place.add')}}" method="post">
            @csrf
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
                    <input type="text" class="form-control" placeholder="Place Name (Required)" name="place_name" id="place_name" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-signature"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Address 1 (Required)" name="place_address_1" id="place_address_1" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Address 2" name="place_address_2" id="place_address_2">
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Address 3" name="place_address_3" id="place_address_3">
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place Area" name="place_address_area" id="place_address_area">
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place City (Required)" name="place_address_city" id="place_address_city" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place County (Required)" name="place_address_county" id="place_address_county" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Place Postcode" name="place_address_postcode" id="place_address_postcode" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-address-book"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Latitude" name="place_location_lat" id="place_location_lat" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-crosshairs"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Longitude" name="place_location_lng" id="place_location_lng" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-crosshairs"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <select class="form-control" name="place_status" id="place_status">
                      <option value="-1">Place Status</option>
                      @if (isset($placeStatuses) && !empty($placeStatuses))
                        @for ($i=0; $i < count($placeStatuses); $i++)
                          <option value="{{$placeStatuses[$i]['place_status_id']}}">{{$placeStatuses[$i]['place_status']}}</option>
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
              <button type="submit" class="btn btn-primary btn-block btn-flat">Add Place</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('backend.includes.auth-password-reveal')
  <script type="text/javascript" src="/js/password-generator.js"></script>
@endsection
