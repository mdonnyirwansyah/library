@extends('layouts.skeleton')

@section('body')
<section class="section">
  <div class="container mt-5">
    <div class="row">
      <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
        <div class="login-brand">
          <img src="{{ asset('assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
        </div>
        @if(session()->has('info'))
        <div class="alert alert-primary">
          {{ session()->get('info') }}
        </div>
        @endif
        @if (session('status') == 'verification-link-sent')
        <div class="alert alert-info">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
        @elseif(session()->has('status'))
        <div class="alert alert-info">
          {{ session()->get('status') }}
        </div>
        @endif
        @yield('content')
        <div class="simple-footer">
          Copyright &copy; {{ config('app.name') }} {{ date('Y') }}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
