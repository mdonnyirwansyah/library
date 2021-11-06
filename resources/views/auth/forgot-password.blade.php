@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Forgot Password') }}</h4>
    </div>
    <div class="card-body">
        <p class="text-muted">{{ __('We will send a link to reset your password') }}</p>
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Forgot Password') }}</button>
        </form>
    </div>
</div>
@endsection