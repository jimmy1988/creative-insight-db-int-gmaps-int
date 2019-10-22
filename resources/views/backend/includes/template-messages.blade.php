@if ($errors->any() )
  <div class="row auth-messages">
    <div class="col-xs-12">
      <div id="register-messages" class="alert-box">
          <div class="alert alert-danger alert-box" id="register-errors">
            <ul>
            @foreach ($errors->all() as $error)
              <li>{{$error}}</li>
            @endforeach
            </ul>
          </div>
      </div>
    </div>
  </div>
@endif

@if (session('messages') != null && !empty(session('messages')))
  <?php $messages = session('messages'); ?>

  <div class="row auth-messages">
    <div class="col-xs-12">
      <div id="all-messages" class="alert-box">
        @if ($messages['errors'] != null && !empty($messages['errors']) && is_array($messages['errors']) && count($messages['errors']) > 0)
          <div class="alert alert-danger alert-box" id="all-errors">
            <ul>
              @foreach ($messages['errors'] as $error)
                <li>{{$error}}</li>
              @endforeach
            </ul>
          </div>
        @endif

        @if ($messages['success'] != null && !empty($messages['success']) && is_array($messages['success']) && count($messages['success']) > 0)
          <div class="alert alert-success alert-box" id="all-success">
            <ul>
            @foreach ($messages['success'] as $success)
              <li>{{$success}}</li>
            @endforeach
            </ul>
          </div>
        @endif

      </div>
    </div>
  </div>
@endif
