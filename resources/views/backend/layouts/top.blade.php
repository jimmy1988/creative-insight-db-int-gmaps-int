<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Page Title -->
    <title>@if (isset($pageTitle) && !empty($pageTitle)) {{$pageTitle . " - "}} @endif @if (env('APP_NAME')) {{env('APP_NAME')}} @else {{"Creative Insight Developer Test Admin" }} @endif </title>

    @include('backend.includes.top.meta-tags')

    @include('backend.includes.top.fonts')

    @include('backend.includes.top.styles')

    @include('backend.includes.top.other-components')

</head>

<body>
