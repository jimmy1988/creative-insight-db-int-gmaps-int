{{-- {{ Verify the users email address }} --}}

{{-- {{ Get the email template }} --}}
@extends('backend.templates.email_template')
@section('content')

  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="750" class="container">
      <tr>
        <td>
          <h2 style="text-align:center;">Password Reset Request</h2>
        </td>
      </tr>
      <tr>
          <td style="padding: 25px 10px;">Dear {{$data->user_first_name . " " . $data->user_surname}}</td>
      </tr>
      <tr>
          <td style="padding: 5px 10px;">We have recieved a request to reset your password, if this is you please click on the link below and reset your password, if this wasnt you please report it and discard this email. </td>
      </tr>
      <tr>
        <td style="padding: 10px 10px;">
          Please click on the button below to reset your password.
        </td>
      </tr>
      <tr>
        <td style="padding: 5px 10px;">
          <a href="{{url('/admin/password/reset/' . $data->user_id_hash . "/" . $data->user_password_reset_token)}}" class="btn bg-grey">Reset Password</a>
        </td>
      </tr>
      <tr>
        <td style="padding: 5px 10px;">
          If you cannot open this link then please copy and paste this link in your browser to verify your account manually,
          <a href="{{url('/admin/password/reset/' . $data->user_id_hash . "/" . $data->user_password_reset_token)}}">{{url('/admin/password/reset/' . $data->user_id_hash . "/" . $data->user_password_reset_token)}}</a>
        </td>
      </tr>
      <tr>
        <td style="padding: 25px 10px;">
          Yours Sincerely
        </td>
      </tr>
      <tr>
        <td style="padding: 25px 10px;">
          The Creative Insight Team
        </td>
      </tr>
  </table>

@endsection
