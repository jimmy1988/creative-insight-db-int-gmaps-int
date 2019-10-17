@extends('backend.templates.auth')

@section('content')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-2 col-sm-4">
        &nbsp;
      </div>
      <div class="col-xs-8 col-sm-4">

        @include('backend.includes.template-messages')
        <div class="card auth-card">
          <form action="{{route('admin.password.update')}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="{{$user_id_hash}}"/>
            <input type="hidden" name="password_reset_token" value="{{$password_reset_token}}"/>
            <div class="card-header text-center">
              <div class="login-logo">
                <a href="/">
                  <img alt="Project Logo" src="/images/logo.png" class="auth-logo"/>
                </a>
              </div>
            </div>
            <div class="card-body">
              <div class="login-box">
                <div class="login-box-body">
                  <h4 class="text-center auth-title">@if (isset($pagetitle) && !empty($pageTitle)) {{ $pageTitle }} @else {{ "Reset Password" }} @endif</h4>
                  <div class="form-group has-feedback">
                      <div class="col-xs-10 no-gutters">
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="col-xs-2 text-right no-gutters">
                        <a href="#" toggle="#user_password" class="btn btn-success show-password toggle-password"><i class="fas fa-eye"></i></a>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-8 back-login-custom">
                      <a href="{{route('admin.login')}}" class="btn btn-success">Back to Login</a>
                    </div>
                    <div class="col-xs-4">
                      &nbsp;
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
                <!-- /.login-box-body -->
              </div>
              <!-- /.login-box -->
            </div>
            <div class="card-footer text-right">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-xs-2 col-sm-4">
        &nbsp;
      </div>
    </div>
  </div>

  @include('backend.includes.auth-password-reveal')
@endsection
