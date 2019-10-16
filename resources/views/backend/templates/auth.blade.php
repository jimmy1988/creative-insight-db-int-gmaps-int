@include('backend.includes.top-php-cache-control')

@include('backend.layouts.top')

<style type="text/css">
  .logo-mini .main-nav-logo-admin{
    display: none;
  }
</style>

@include('backend.layouts.auth-header')

<div class="main-content auth-content">
  @yield('content')
</div>

@include('backend.layouts.auth-footer')

@include('backend.layouts.scripts')

@include('backend.layouts.bottom')
