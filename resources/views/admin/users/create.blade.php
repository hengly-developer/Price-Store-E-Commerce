@extends('admin.app')
@section('css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}">Dashboard</a> </li>
<li class="breadcrumb-item active"> <a href="">Users</a> </li>
<li class="breadcrumb-item active" aria-current="page">Add/Edit User</li>
@endsection
@section('content')
  <h2 class="modal-title">Add/Edit User</h2>
  <form action="@if(isset($user)) {{ route('admin.profile.update', $user) }} @else {{ route('admin.profile.store') }} @endif" method="post" enctype="multipart/form-data" accept-charset="utf-8">
    {{ csrf_field() }}
    @if (isset($user))
      {{ method_field('PUT') }}
    @endif
    <div class="row">
      <div class="col-lg-9">
        <div class="form-group row">
          <div class="col-md-12">
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
          </div>
          <div class="col-md-12">
            @if (session()->has('message'))
              <div class="alert alert-success">
                {{ session('message') }}
              </div>
            @endif
          </div>
          <div class="col-sm-12 col-md-6">
            <label class="form-control-label">Name:</label>
            <input type="text" name="name" id="txturl" value="{{ @$user->profile->name }}" class="form-control">
            <p class="small">{{ route('admin.profile.index') }} <span id="url">{{ @$user->profile->slug }}</span>
              <input type="hidden" name="slug" id="slug" value="{{ @$user->profile->slug }}">
            </p>
          </div>
          <div class="col-sm-12 col-md-6">
            <label class="form-control-label">Email:</label>
            <input type="text" name="email" id="email" value="{{ @$user->email }}" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12 col-md-6">
            <label class="form-control-label">Password:</label>
            <input type="password" name="password" id="password" value="" class="form-control">
          </div>
          <div class="col-sm-12 col-md-6">
            <label class="form-control-label">Confirm Paswword:</label>
            <input type="password" name="confirm_password" id="confirm_password" value="" class="form-control">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6 col-md-6">
            <label class="form-control-label">Status:</label>
            <div class="input-group mb-3">
              <select class="form-control" name="status">
                <option value="0" @if (isset($user) && $user->status == 0) {{ 'selected' }} @endif>Blocked</option>
                <option value="1" @if (isset($user) && $user->status == 1) {{ 'selected' }} @endif>Active</option>
              </select>
            </div>
          </div>
          @php
            $ids = (isset($user->role) && $user->role->count() > 0) ? array_pluck($user->role->toArray(), 'id') : null
          @endphp
          <div class="col-sm-6 col-md-6">
            <label class="form-control-label">Select Role:</label>
            <div class="input-group mb-3">
              <select class="form-control" name="role_id" id="role">
                @if ($roles->count() > 0)
                  @foreach ($roles as $role)
                    <option value="{{ $role->id }}"
                      @if (!is_null($ids) && in_array($role->id, $ids))
                      {{ 'selected' }} @endif>
                        {{ $role->name }}
                    </option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-12 col-md-12">
            <label class="form-control-label">Address:</label>
            <div class="input-group mb-3">
              <input type="text" name="address" class="form-control" value="{{ @$user->address }}" placeholder="Address">
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-sm-6 col-md-3">
            <label class="form-control-label">Country:</label>
            <div class="input-group mb-3">
              <select class="form-control" name="country_id" id="countries">
                <option>Choose Country</option>
                @foreach ($countries as $country)
                  <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <label class="form-control-label">State:</label>
            <div class="input-group mb-3">
              <select class="form-control" name="state_id" id="states">
                <option>Choose State</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <label class="form-control-label">City:</label>
            <div class="input-group mb-3">
              <select class="form-control" name="city_id" id="cities">
                <option>Choose City</option>
              </select>
            </div>
          </div>
          <div class="col-sm-6 col-md-3">
            <label class="form-control-label">Phone:</label>
            <div class="input-group mb-3">
              <input type="text" name="phone" class="form-control" placeholder="Phone" value="{{ @$user->phone }}">
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <ul class="list-group row">
          <li class="list-group-item active"> <h5>Profile Image</h5> </li>
          <li class="list-group-item">
            <div class="input-group mb-3">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail" value="">
                <label class="custom-file-label" for="thumbnail">Choose file</label>
              </div>
            </div>
            <div class="img-thumbnail text-center">
              <img src="@if(isset($user)) {{ asset('storage/' . $user->thumbnail) }} @else {{ asset('images/no-thumbnail.png') }} @endif"
              id="imgthumbnail" class="img-fluid">
            </div>
          </li>
          <li class="list-group-item">
            <div class="col-md-12">
              @if(isset($user))
                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Update User">
              @else
                <input type="submit" name="submit" class="btn btn-primary btn-block" value="Add User">
              @endif
            </div>
          </li>
        </ul>
      </div>
    </div>
  </form>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script>
      $(document).ready(function() {
        $('#txturl').on('keyup', function() {
          const pretty_url = slugify($(this).val())
          $('#url').html(slugify(pretty_url))
          $('#slug').val(pretty_url)
        })

        $('#thumbnail').on('change', function() {
          var file = $(this).get(0).files;
          var reader = new FileReader();
          reader.readAsDataURL(file[0]);
          reader.addEventListener("load", function(e) {
            var image = e.target.result;
            $('#imgthumbnail').attr('src', image);
          });
        });

        $('#countries').select2();
        $('#states').select2();
        $('#cities').select2();

        /* On Country Change */
        $('#countries').on('change', function() {
          var id = $('#countries').select2('data')[0].id
          $('#states').val(null)
          $('#states option').remove()
          var state = $('#states')
          $.ajax({
            type: 'GET',
            url: "{{ route('admin.profile.states') }}/" + id
          }).then(function(data){
            for (i = 0; i < data.length; i++){
              var item = data[i]
              var option = new Option(item.name, item.id, true, true)
              state.append(option)
            }
            state.trigger('change')
          })
        })

        /* On State Change */
        $('#states').on('change', function() {
          var id = $('#states').select2('data')[0].id
          $('#cities').val(null)
          $('#cities option').remove()
          var city = $('#cities')
          $.ajax({
            type: 'GET',
            url: "{{ route('admin.profile.cities') }}/" + id
          }).then(function(data){
            for (i = 0; i < data.length; i++){
              var item = data[i]
              var option = new Option(item.name, item.id, false, false)
              city.append(option)
            }
          })
        })

      });
  </script>
@endsection
