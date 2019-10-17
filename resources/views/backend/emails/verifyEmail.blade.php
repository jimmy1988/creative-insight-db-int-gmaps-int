{{-- {{ Verify the users email address }} --}}

{{-- {{ Get the email template }} --}}
@extends('backend.templates.email_template')
@section('content')

  <table role="presentation" aria-hidden="true" cellspacing="0" cellpadding="0" border="0" align="center" width="750" class="container">
      <tr>
        <td>
          <h2 style="text-align:center;">Email Verification Required</h2>
        </td>
      </tr>
      <tr>
          <td style="padding: 25px 10px;">Dear {{$data->user_first_name . " " . $data->user_surname}}</td>
      </tr>
      <tr>
          <td style="padding: 5px 10px;">You have been registered on the Pride Shark Admin System, you just need to do one more thing before you can start using the system. </td>
      </tr>
      <tr>
        <td style="padding: 10px 10px;">
          Please click on the button below to verify that this email is yours and you can login as normal.
        </td>
      </tr>
      <tr>
        <td style="padding: 5px 10px;">
          <a href="{{url('/admin/email/verify/' . $data->user_id_hash . "/" . $data->user_email_verify_token)}}" class="btn bg-grey">Verify My Account</a>
        </td>
      </tr>
      <tr>
        <td style="padding: 5px 10px;">
          If you cannot open this link then please copy and paste this link in your browser to verify your account manually,
          <a href="{{url('/admin/email/verify/' . $data->user_id_hash . "/" . $data->user_email_verify_token)}}">{{url('/admin/email/verify/' . $data->user_id_hash . "/" . $data->user_email_verify_token)}}</a>
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
