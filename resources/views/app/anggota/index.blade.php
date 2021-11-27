@extends('layouts.app')

@section('title', 'Anggota')

@push('javascript')
  {!! $dataTable->scripts() !!}
  @include('app.anggota.actions')
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Anggota</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Anggota</div>
    </div>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="col-12">
          <div class="section-header-button mb-3">
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">Tambah</a>
            <a href="{{ route('anggota.import') }}" class="btn btn-success">Import</a>
          </div>
          <hr>
          {!! $dataTable->table(['class' => 'table table-bordered table-striped dt-responsive nowrap', 'cellpadding' => '0', 'style' => 'width: 100%']) !!}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
