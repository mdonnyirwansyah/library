@extends('layouts.app')

@section('title', 'Update Password')

@push('javascript')
@if(session()->has('status'))
<script>
  toastr.success("{{ __('Password has been updated') }}", 'Congratulations,');
</script>
@endif
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ route('dashboard') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Update Password</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Update Password</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h4 class="text-dark">Akun</h4>
          </div>
          <div class="card-body">
            <ul class="nav nav-pills flex-column">
              <li class="nav-item">
                <a href="{{ route('user-profile-information') }}" class="nav-link text-dark">Informasi Profil</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user-password') }}" class="nav-link active">Update Password</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <form method="POST" action="{{ route('user-password.update') }}">
          @method('PUT')
          @csrf
          <div class="card" id="settings-card">
            <div class="card-body">
              <div class="form-group row align-items-center">
                <label for="current_password" class="form-control-label col-sm-3 text-md-right">Current Password</label>
                <div class="col-sm-6 col-md-9">
                  <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" name="current_password" id="current_password">
                  @error('current_password', 'updatePassword')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="password" class="form-control-label col-sm-3 text-md-right">New Password</label>
                <div class="col-sm-6 col-md-9">
                  <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" name="password" id="password">
                  @error('password', 'updatePassword')
                  <span class="invalid-feedback" role="alert">
                      <small>{{ $message }}</small>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row align-items-center">
                <label for="password_confirmation" class="form-control-label col-sm-3 text-md-right">Confirm Password</label>
                <div class="col-sm-6 col-md-9">
                  <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
                </div>
              </div>
            </div>
            <div class="card-footer bg-whitesmoke text-md-right">
              <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
              <button class="btn btn-secondary" type="reset">Reset</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
