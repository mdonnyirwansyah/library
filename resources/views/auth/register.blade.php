@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Register') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="control-label">{{ __('Email') }}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email ?? old('email') }}">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama" class="control-label">{{ __('Nama') }}</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $nama ?? old('nama') }}">
                @error('nama')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <input type="hidden" name="role" value="1">
            <div class="form-group">
                <label for="password" class="control-label">{{ __('Password') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="control-label">{{ __('Konfirmasi Password') }}</label>
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" name="password_confirmation">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Register') }}</button>
        </form>
    </div>
</div>
@endsection
