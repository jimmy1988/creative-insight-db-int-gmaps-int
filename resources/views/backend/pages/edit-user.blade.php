@extends('backend.templates.admin')

@section('content')
  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12 auth-container">

        <div class="card auth-card">
          <form action="{{route('admin.user.update')}}" method="post">
            @csrf
            <input type="hidden" name="user_id" value="@if (isset($userToEdit['user_id_hash']) && !empty($userToEdit['user_id_hash'])) {{$userToEdit['user_id_hash']}} @else "0" @endif" />
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
                  <h4 class="text-center auth-title">@if (isset($pageTitle) && !empty($pageTitle)) {{ $pageTitle }} @else {{ "Register" }} @endif</h4>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="First Name" name="user_first_name" id="user_first_name" value="@if (isset($userToEdit['user_first_name']) && !empty($userToEdit['user_first_name'])) {{$userToEdit['user_first_name']}} @endif"  required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-user"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Surname" name="user_surname" id="user_surname" value="@if (isset($userToEdit['user_surname']) && !empty($userToEdit['user_surname'])) {{$userToEdit['user_surname']}} @endif" required>
                    <span class="glyphicon form-control-feedback"><i class="fas fa-user"></i></span>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="user_email" id="user_email" value="@if (isset($userToEdit['user_email']) && !empty($userToEdit['user_email'])) {{$userToEdit['user_email']}} @endif" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                  <div class="alert alert-info">
                    <p>
                      For security reasons passwords are not displayed here, you can change your password or generate a new one, however this will overwrite the one you currently use
                    </p>
                  </div>
                  <div class="form-group has-feedback">
                      <div class="col-xs-8 no-gutters">
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="col-xs-4 text-right no-gutters">
                        <a href="#" class="btn btn-info generate-password-button">Generate New</a>
                        <a href="#" toggle="#user_password" class="btn btn-success show-password toggle-password"><i class="fas fa-eye"></i></a>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                  <div class="form-group has-feedback">
                      <div class="col-xs-10 no-gutters">
                        <input type="password" class="form-control" id="user_password_confirm" name="user_password_confirm" placeholder="Confirm Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                      </div>
                      <div class="col-xs-2 text-right no-gutters">
                        <a href="#" toggle="#user_password_confirm" class="btn btn-success show-password toggle-password"><i class="fas fa-eye"></i></a>
                      </div>
                  </div>
                  <div class="clearfix"></div>
                  @if (isset($userStatuses) && !empty($userStatuses) && $userStatuses->count() > 0)
                    <div class="form-group has-feedback custom-form-control">
                        <select class="form-control" name="user_status">
                          @foreach ($userStatuses as $userStatus => $status)
                            <option value="{{$status->user_status_id}}"
                            @if ($status->user_status_id == $userToEdit['user_status'])
                              {{ "selected" }}
                            @endif
                            >{{$status->user_status}}</option>
                          @endforeach
                        </select>
                    </div>
                  @endif

                </div>
                <!-- /.login-box-body -->
              </div>
              <!-- /.login-box -->
            </div>
            <div class="card-footer text-right auth-footer">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Edit User</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('backend.includes.auth-password-reveal')
  <script type="text/javascript" src="/js/password-generator.js"></script>
@endsection
