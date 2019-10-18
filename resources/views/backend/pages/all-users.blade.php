@extends('backend.templates.admin')

@section('content')

  @include('backend.layouts.titlebar')
  @include('backend.includes.template-messages')

  <div class="container-fluid">
    <div class="row">
      <div class="col-xs-12">
        <div id="all-users-table-container" class="table-responsive">
          <table class="table table-striped table-hover table-condensed">
            <thead>
              <tr>
                <th>&nbsp;</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>User Status</th>
                <th>Date Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @if (isset($allUsers) && !empty($allUsers) && $allUsers->count() > 0)
                @foreach ($allUsers as $user => $details)

                  <?php
                    $userStatusClass = "";
                    $userStatusIcon = "";

                    switch ($details->user_status) {
                      case "1":
                        $userStatusClass = "";
                        $userStatusIcon = "<i class=\"far fa-hourglass\" title=\"" . $details->userStatus->user_status . "\"></i>";
                        break;
                      case "2":
                        $userStatusClass = "info";
                        $userStatusIcon = "<i class=\"fas fa-sign-out-alt\" title=\"" . $details->userStatus->user_status . "\"></i>";
                        break;
                      case "3":
                        $userStatusClass = "success";
                        $userStatusIcon = "<i class=\"fas fa-check\" title=\"" . $details->userStatus->user_status . "\"></i>";
                        break;
                      case "4":
                        $userStatusClass = "warning";
                        $userStatusIcon = "<i class=\"fas fa-ban\" title=\"" . $details->userStatus->user_status . "\"></i>";
                        break;
                      case "5":
                        $userStatusClass = "danger";
                        $userStatusIcon = "<i class=\"fas fa-times\" title=\"" . $details->userStatus->user_status . "\"></i>";
                        break;
                      default:
                        $userStatusClass = "";
                        $userStatusIcon = "";
                        break;
                    }
                  ?>

                  <tr class="{{ $userStatusClass }}">
                    <td>&nbsp;</td>
                    <td>{{ $details->user_first_name . " " .  $details->user_surname }}</td>
                    <td>{{ $details->user_email }}</td>
                    <td>{!! $userStatusIcon !!}</td>
                    <td>Date Created</td>
                    <td>
                      @if ($thisUser['user_id'] == $details->user_id)
                        <a href="{{ route('admin.user.profile', $details->user_id_hash) }}" class="btn btn-success btn-edit-custom">
                          <i class="fas fa-user-edit"></i>
                        </a>
                      @else
                        <a href="{{ route('admin.user.edit.showForm', $details->user_id_hash) }}" class="btn btn-success btn-edit-custom">
                          <i class="fas fa-user-edit"></i>
                        </a>
                        @if (isset($thisUser['user_allow_delete']) && !empty($thisUser['user_allow_delete']) && strtolower($thisUser['user_allow_delete']) != 'yes')
                          <form action="{{route('admin.user.delete.soft', $details->user_id_hash)}}" method="post" class="delete-form">
                            @csrf
                            <input type="hidden" name="_method" value="delete" />
                            <button type="submit" class="btn btn-danger btn-edit-custom">
                              <i class="fas fa-times"></i>
                            </button>
                          </form>
                        @endif
                      @endif
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="6" class="text-center">No Users Found</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

@endsection
