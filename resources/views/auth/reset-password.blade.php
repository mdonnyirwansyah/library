@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Reset Password') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->token }}" />
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
                <label for="password" class="control-label">{{ __('New Password') }}</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>
                <input type="password" class="form-control" id="password-confirm" name="password_confirmation" />
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Reset Password') }}</button>
        </form>
    </div>
</div>
@endsection