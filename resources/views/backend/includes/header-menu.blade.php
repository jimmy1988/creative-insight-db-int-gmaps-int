<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </a>

  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <!-- User Account: style can be found in dropdown.less -->
      <li class="dropdown user user-menu">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <img src="/images/user-placeholder.png" class="user-image" alt="User Image">
          <span class="hidden-xs">{{$thisUser['user_first_name'] . " " . $thisUser['user_surname']}}</span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="/images/user-placeholder.png" class="img-circle" alt="User Image">
          </li>

          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="{{route('admin.user.profile')}}" class="btn btn-info btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <form action="{{route('admin.logout')}}" method="post">
                @csrf
                <button type="submit" name="submit" value="log_out" class="btn btn-success btn-flat">Log Out</a>
              </form>

            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
