@extends('layouts.auth')

@section('title', 'Confirm Password')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Confirm Password') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf
            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">{{ __('Password') }}</label>
                    <div class="float-right">
                        <a href="{{ route('password.email') }}" class="text-small">{{ __('Forgot Password') }}?</a>
                    </div>
                </div>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Confirm Password') }}</button>
        </form>
    </div>
</div>
@endsection