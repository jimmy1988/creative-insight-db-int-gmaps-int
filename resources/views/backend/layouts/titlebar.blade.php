<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    @if (isset($pageTitle) && !empty($pageTitle))
      {{ $pageTitle }}
    @endif

    @if (isset($subPageTitle) && !empty($subPageTitle))
      <small>{{ $subPageTitle }}</small>
    @endif
  </h1>
</section>
