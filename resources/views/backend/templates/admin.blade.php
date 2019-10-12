@include('backend.includes.top.php-cache-control')

@include('backend.layouts.top')

@include('backend.layouts.header')

@include('backend.layouts.sidebar')

<div class="main-content">
  @yield('content')
</div>

@include('backend.layouts.footer')

@include('backend.layouts.scripts')

@include('backend.layouts.bottom')
