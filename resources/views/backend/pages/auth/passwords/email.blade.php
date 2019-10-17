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
          <form action="{{route('admin.password.email')}}" method="post">
            @csrf
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
                  <h4 class="text-center auth-title">@if (isset($pageTitle) && !empty($pageTitle)) {{ $pageTitle }} @else {{ "Request New Password" }} @endif</h4>
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" value="@if (session('user_email') != null && !empty(session('user_email'))) {{ session('user_email') }} @endif" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-8 no-gutters">
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
              <button type="submit" class="btn btn-primary btn-block btn-flat">Request Password</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-xs-2 col-sm-4">
        &nbsp;
      </div>
    </div>
  </div>
@endsection
