<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li>
        <a href="{{route('admin.index')}}" class="btn btn-info text-black text-left">
          <i class="fas fa-tachometer-alt"></i>&nbsp;<span>Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{route('index')}}" target="_blank" class="btn btn-success text-black text-left">
          <i class="fas fa-globe-europe"></i>&nbsp;<span>Website</span>
        </a>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fas fa-location-arrow"></i>&nbsp;<span>Places</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('admin.places')}}"><i class="fas fa-map-marker-alt"></i>&nbsp;All Places</a></li>
          <li><a href="{{route('admin.place.add.showForm')}}"><i class="fas fa-plus"></i>&nbsp;Add Place</a></li>
          <li><a href="{{route('admin.places.deleted')}}"><i class="fas fa-times"></i>&nbsp;Deleted Places</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fas fa-users"></i>&nbsp;<span>Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{route('admin.users')}}"><i class="fas fa-user-friends"></i>&nbsp;All Users</a></li>
          <li><a href="{{route('admin.user.add.showForm')}}"><i class="fas fa-user-plus"></i>&nbsp;Add User</a></li>
          <li><a href="{{route('admin.users.deleted')}}"><i class="fas fa-user-times"></i>&nbsp;Deleted Users</a></li>
        </ul>
      </li>
  </section>
  <!-- /.sidebar -->
</aside>
