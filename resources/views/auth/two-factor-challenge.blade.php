@extends('layouts.auth')

@section('title', 'Two Factor Challenge')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Two Factor Challenge') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf
            <div class="form-group">
                <div class="d-block">
                    <label for="code" class="control-label">{{ __('Code') }}</label>
                    <div class="float-right">
                        <a href="{{ route('two-factor-recovery') }}" class="text-small">{{ __('Two factor authentication device is lost') }}?</a>
                    </div>
                </div>
                <input type="code" class="form-control @error('code') is-invalid @enderror" id="code" name="code">
                @error('code')
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