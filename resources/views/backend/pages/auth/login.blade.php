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
          <form action="{{route('admin.login')}}" method="post">
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
                  <h4 class="text-center auth-title">@if (isset($pageTitle) && !empty($pageTitle)) {{ $pageTitle }} @else {{ "Login" }} @endif</h4>
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" value="@if (session('user_email') != null && !empty(session('user_email'))) {{ session('user_email') }} @endif" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <div class="col-xs-10 no-gutters">
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="col-xs-2 text-right no-gutters">
                        <a href="#" toggle="#user_password" class="btn btn-success show-password toggle-password"><i class="fas fa-eye"></i></a>
                      </div>
                  </div>
                  <div class="form-group form-checkbox">
                    <div class="col-xs-8">
                      <div class="checkbox icheck">
                        <label>
                          <input type="checkbox" id="remember_me" name="remember_me"> Remember Me
                        </label>
                      </div>
                    </div>
                    <div class="col-xs-4 text-right">
                      &nbsp;
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-8 no-gutters">
                      <a href="{{route('admin.password.request')}}" class="btn btn-success">Reset Password</a>
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
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
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
