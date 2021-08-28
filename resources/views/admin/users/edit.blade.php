@extends('templates.main')

@section('title_page')
    Users
@endsection

@section('breadcrumb_title')
    users
@endsection

@section('content')
<div class="row">
  <div class="col-md-10">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Edit User Data</h3>
      </div>
      <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="card-body">

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Full Name</label>
                <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}">
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Username</label>
                <input class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username', $user->username) }}">
              </div>
              @error('username')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Email</label>
                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}">
              </div>
              @error('email')
                <div class="invalid-feedback">
                  {{ $message }}
                </div>
              @enderror
            </div>
          </div>

          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Project</label>
                <select name="projects_id" class="form-control select2bs4" style="width: 100%;">
                  @foreach ($projects as $project)
                    <option value="{{ $project->project_id }}" {{ $project->project_id === $user->projects_id ? 'selected' : '' }}>{{ $project->project_code }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control select2bs4" style="width: 100%;"> 
                  <option value="USER" {{ $user->role === 'USER' ? 'selected' : '' }}>USER</option>
                  <option value="ADMIN" {{ $user->role === 'ADMIN' ? 'selected' : '' }}>ADMIN</option>
                </select>
              </div>
            </div>
          </div>         
          
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>  Save</button>
            </div>
          </div>
        </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('styles')
    <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('scripts')
  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
  <script>
    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
    }) 
  </script>
@endsection