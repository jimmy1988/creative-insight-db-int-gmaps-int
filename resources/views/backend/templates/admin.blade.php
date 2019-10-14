@include('backend.includes.top-php-cache-control')

@include('backend.layouts.top')

@include('backend.layouts.header')

@include('backend.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  @include('backend.layouts.titlebar')
  @include('backend.includes.template-messages')
  <div class="main-content">
        @yield('content')
  </div>
</div>

@include('backend.layouts.footer')

@include('backend.layouts.scripts')

@include('backend.layouts.bottom')
