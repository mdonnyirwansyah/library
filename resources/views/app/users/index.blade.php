@extends('layouts.app')

@section('title', 'Users')

@push('javascript')
  {!! $dataTable->scripts() !!}
  @include('app.users.actions')
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Users</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Users</div>
    </div>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="col-12">
          <div class="section-header-button mb-3">
            <button class="btn btn-primary" onClick="createRecord()">Tambah</button>
          </div>
          <hr>
          {!! $dataTable->table(['class' => 'table table-bordered table-striped dt-responsive nowrap', 'cellpadding' => '0', 'style' => 'width: 100%']) !!}
        </div>
      </div>
    </div>
  </div>
</section>
<div id="view-modal" style="display: none"></div>
@endsection
