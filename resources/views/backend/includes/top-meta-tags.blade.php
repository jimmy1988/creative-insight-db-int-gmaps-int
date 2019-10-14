<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!--Meta Cache control-->
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" /

<!--SEO & other meta tags-->
@if (isset($metaTags) && !empty($metaTags))
 @for($i=0; $i < count($metaTags); $i++)
  <meta
  @foreach ($metaTags[$i] as $attribute => $value)
   {{ $attribute }} = '{{ $value }}'
  @endforeach
  />
 @endfor
@endif
