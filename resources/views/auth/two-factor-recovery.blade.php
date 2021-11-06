@extends('layouts.auth')

@section('title', 'Two Factor Recovery')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Two Factor Recovery') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <div class="form-group">
                <div class="d-block">
                    <label for="recovery_code" class="control-label">{{ __('Recovery Code') }}</label>
                </div>
                <input type="recovery_code" class="form-control @error('recovery_code') is-invalid @enderror" id="recovery_code" name="recovery_code">
                @error('recovery_code')
                    <span class="invalid-feedback" role="alert">
                        <small>{{ $message }}</small>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-lg btn-block btn-primary">{{ __('Submit') }}</button>
        </form>
    </div>
</div>
@endsection