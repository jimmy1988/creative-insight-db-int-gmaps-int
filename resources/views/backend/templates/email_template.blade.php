{{-- {{ Basic email template }} --}}

{{-- {{ Get the top of the document }} --}}
@include('backend.layouts.emails.top')
{{-- {{ Get the header }} --}}
@include('backend.layouts.emails.header')
{{-- {{ Get the email content }} --}}
@yield('content')
{{-- {{ Get the footer of the document }} --}}
@include('backend.layouts.emails.footer')
{{-- {{ Close the document }} --}}
@include('backend.layouts.emails.bottom')
