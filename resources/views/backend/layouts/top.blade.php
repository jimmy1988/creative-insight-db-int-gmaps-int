<!DOCTYPE html>
<html>
  <head>

    <title>@if (isset($pageTitle) && !empty($pageTitle)) {{$pageTitle . " - "}} @endif @if (env('APP_NAME')) {{env('APP_NAME')}} @else {{"Creative Insight Developer Test" }} @endif Admin</title>

    @include('backend.includes.top-meta-tags')

    @include('backend.includes.top-styles')

    @include('backend.includes.top-favicon')


    <!-- jQuery 3 -->
    <script src="/template/bower_components/jquery/dist/jquery.min.js"></script>
  </head>

  <!-- ADD THE CLASS fixed TO GET A FIXED HEADER AND SIDEBAR LAYOUT -->
  <!-- the fixed layout is not compatible with sidebar-mini -->
  <body class="hold-transition skin-blue fixed sidebar-mini">
