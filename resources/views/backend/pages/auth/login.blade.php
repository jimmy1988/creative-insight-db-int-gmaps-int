@extends('backend.templates.auth')

@section('content')

  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-2 col-sm-4">
        &nbsp;
      </div>
      <div class="col-xs-8 col-sm-4">

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
                  <h4 class="text-center auth-title">Login</h4>
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" required>
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
                          <input type="checkbox"> Remember Me
                        </label>
                      </div>
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
