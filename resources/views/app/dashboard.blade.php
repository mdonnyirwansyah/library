@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Dashboard</h1>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-primary">
          <i class="fas fa-user-friends"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Users</h4>
          </div>
          <div class="card-body">
            {{ $totalUsers }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
          <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Anggota</h4>
          </div>
          <div class="card-body">
            {{ $totalAnggota }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
          <i class="fas fa-school"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Kelas</h4>
          </div>
          <div class="card-body">
            {{ $totalKelas }}
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
      <div class="card card-statistic-1">
        <div class="card-icon bg-success">
          <i class="fas fa-book"></i>
        </div>
        <div class="card-wrap">
          <div class="card-header">
            <h4>Total Buku</h4>
          </div>
          <div class="card-body">
            {{ $totalBuku }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="section-body">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <img class="img-fluid" src="{{ asset('assets/img/bg-sma.jpg') }}" alt="image">
            </div>
        </div>
    </div>
  </div>
</section>
@endsection
