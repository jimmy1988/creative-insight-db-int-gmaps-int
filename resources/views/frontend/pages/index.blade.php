@extends('frontend.templates.frontend')

@section('content')

<div class="container-fluid no-gutters" id="map-container">
  <form method="post" action="" id="searchForm">
    <div class="row" id="search-container">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
          <div class="form-group">
            <div class="row">
              <div id="search-box-container" class="col-md-10">
                <div class="form-group">
                  <input type="text" id="search-box" class="form-control" placeholder="Search For Businesses e.g.Nandos"/>
                  <div class="" id="search-results-container">
                    {{-- <a href="#" class="container-fluid search-result">
                      <div class="row">
                        <div class="col-xs-9 col-md-9 search-column-1">
                          <h4 class="text-center search-place-name">Nando's West Bromwich</h4>
                          <p class="text-center search-place-address">Unit 5A New Square, Walsall St, West Bromwich, Birmingham, West Midlands, B70 7PP</p>
                        </div>
                        <div class="col-xs-3 col-md-3 text-center search-column-2">
                          <p>
                            <span class="miles-amount">
                              1.2
                            </span>
                            <span>Miles</span>
                          </p>
                        </div>
                      </div>
                    </a> --}}
                  </div>
                </div>
              </div>
              <div id="distance-container" class="col-md-2">
                <div class="form-group">
                  <select class="form-control" id="distance-box">
                    @for ($i=0; $i <= 25; $i)
                      <option value="{{$i}}">{{$i}} Miles +</option>
                      <?php $i = $i + 5; ?>
                    @endfor
                  </select>
                </div>
              </div>
              {{-- <div id="search-button-container" class="col-md-2">
                <button type="submit" id="search-button" class="btn btn-secondary"><i class="fas fa-crosshairs"></i></button>
              </div> --}}
            </div>
          </div>
      </div>
    </div>
  </form>
  <div class="row" id="google-map-container">
    <div class="col-md-9 no-gutters" id="mapContainerMain" style="display:block; width:100% !important; max-width:100%;flex:unset;">
      <div id="map"></div>
    </div>
    <div class="col-md-3 no-gutters" id="resultsContainer">
      <div class="card" id="rightPane">
        <div class="card-header text-center" id="rightPaneHeader">
          &nbsp;
        </div>
        <div class="card-body no-gutters" id="rightPaneContent">

        </div>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid no-gutters" id="curtain-outer">
  <div class="row text-center" id="curtain-inner">
    <div class="col-xs-12">
      <p>
        <i class="fas fa-crosshairs fa-spin"></i>
      </p>
      <p>
        Loading...
      </p>
    </div>
  </div>
</div>

<script type="text/javascript">
  var ajaxSearchRoute = "{{route('index.ajax.searchPlaces')}}";
</script>


@endsection
