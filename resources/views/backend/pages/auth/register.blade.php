@extends('backend.templates.admin')

@section('content')
  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 auth-container">

        <div class="card auth-card">
          <form action="{{route('admin.register')}}" method="post">
            @csrf
            <div class="card-header text-center">
              <div class="login-logo">
                <a href="/">
                  <img alt="Project Logo" src="/images/logo.png" class="auth-logo"/>
                </a>
              </div>
            </div>
            <div class="card-body auth-body">
              <div class="login-box auth-box">
                <div class="login-box-body auth-box-body">
                  <h4 class="text-center auth-title">Register</h4>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="First Name" name="user_first_name" id="user_first_name" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-user"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Surname" name="user_surname" id="user_surname" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-user"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="form-group has-feedback">
                      <div class="col-xs-8 no-gutters">
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="col-xs-4 text-right no-gutters">
                        <a href="#" class="btn btn-info generate-password-button">Generate</a>
                        <a href="#" toggle="#user_password" class="btn btn-success show-password toggle-password"><i class="fas fa-eye"></i></a>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                  <div class="form-group has-feedback">
                      <div class="col-xs-10 no-gutters">
                        <input type="password" class="form-control" id="user_password_confirm" name="user_password_confirm" placeholder="Confirm Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="col-xs-2 text-right no-gutters">
                        <a href="#" toggle="#user_password_confirm" class="btn btn-success show-password toggle-password"><i class="fas fa-eye"></i></a>
                      </div>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <!-- /.login-box-body -->
              </div>
              <!-- /.login-box -->
            </div>
            <div class="card-footer text-right auth-footer">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('backend.includes.auth-password-reveal')
  <script type="text/javascript" src="/js/password-generator.js"></script>
@endsection
