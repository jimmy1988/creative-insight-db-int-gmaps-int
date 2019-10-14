@include('backend.includes.top-php-cache-control')

@include('backend.layouts.top')

@include('backend.layouts.auth-header')

<div class="main-content">
  @yield('content')
</div>

@include('backend.layouts.auth-footer')

@include('backend.layouts.scripts')

@include('backend.layouts.bottom')
