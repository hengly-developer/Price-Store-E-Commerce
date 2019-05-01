@extends('admin.app')
@section('breadcrumb')
<li class="breadcrumb-item"> <a href="{{ route('admin.dashboard') }}">Dashboard</a> </li>
<li class="breadcrumb-item active" aria-current="page">User</li>
@endsection
@section('content')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h2 class="h2">Users List</h2>
    <hr>
    <div class="btn-toolbar mb-2 mb-md-0">
      <a href="{{ route('admin.profile.create') }}" class="btn btn-sm btn-outline-secondary">Add User</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Slug</th>
          <th>Role</th>
          <th>Address</th>
          <th>Thumbnail</th>
          <th>Create At</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @if (isset($users) && $users->count() > 0)
          @foreach ($users as $user)
            <tr>
              <td>{{ @$user->id }}</td>
              <td>{{ @$user->profile->name }}</td>
              <td>{{ @$user->email }}</td>
              <td>{{ @$user->profile->slug }}</td>
              <td>{{ $user->role->name }}</td>
              <td>{{ @$user->profile->address }}, {{ @$user->getCountry() }}</td>
              <td>
                <img src="{{ asset('storage/images/profile/' . $user->profile->thumbnail) }}" alt="{{ @$user->profile->name }}"
                class="img-responsive" height="50">
              </td>
              @if ($user->trashed())
                <td>{{ @$user->deleted_at }}</td>
                <td>
                  <a href="{{ route('admin.profile.recover', $user->id) }}" class="btn btn-info btn-sm">Restore</a>
                  <a href="javascript:;" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $user->id }}')">Delete</a>
                  <form id="delete-user-{{ $user->id }}" action="{{ route('admin.profile.destroy', $user->profile->slug) }}" method="post"
                    style="display:none;">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                  </form>
                </td>
              @else
              <td>{{ $user->created_at }}</td>
              <td>
                <a href="{{ route('admin.profile.edit', $user->profile->slug) }}" class="btn btn-info btn-sm">Edit</a>
                <a id="trash-user-{{ $user->id }}" class="btn btn-warning btn-sm" href="{{ route('admin.profile.remove', $user->profile->slug) }}">Trash</a>
                <a href="javascript:;" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $user->id }}')">Delete</a>
                <form id="delete-users-{{ $user->id }}" action="{{ route('admin.profile.destroy', $user->profile->slug) }}" method="post"
                  style="display:none;">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                </form>
              </td>
              @endif
            </tr>
          @endforeach
        @else
            <tr>
              <td colspan="12" class="alert alert-info">No Users Found...</td>
            </tr>
        @endif
      </tbody>
    </table>
  </div>
  <div class="row">
    <div class="col-md-12">
      {{ $users->links() }}
    </div>
  </div>
@endsection
@section('script')
<script type="text/javascript">
  function confirmDelete(id) {
    let choice = confirm('Are you sure, You want to delete this record??')
    if (choice) {
      document.getElementById('delete-user-' + id).submit();
    }
  }
</script>
@endsection
