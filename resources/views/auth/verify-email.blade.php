@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="text-dark">{{ __('Verify Your Email Address') }}</h4>
    </div>
    <div class="card-body">
        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
</div>
@endsection