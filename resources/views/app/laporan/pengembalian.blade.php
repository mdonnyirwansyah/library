@extends('layouts.app')

@section('title', 'Laporan Pengembalian')

@push('javascript')
<script>
    $(document).ready( function() {
        $('#kelas').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih kelas',
        });

        $('#tahun_pelajaran').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih tahun pelajaran',
        });

        $('.filter').change(function (e) {
            pengembalian.draw();
            e.preventDefault();
        });

        var pengembalian = $('#pengembalian-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('laporan.get-pengembalian') }}",
                type: "POST",
                data: function (d) {
                    d.kelas = $('#kelas').val();
                    d.tahun_pelajaran = $('#tahun_pelajaran').val();
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            },
            columns: [
                {
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {data: 'kode', name: 'kode'},
                {data: 'tanggal', name: 'tanggal'},
                {data: 'nis', name: 'nis'},
                {data: 'anggota', name: 'anggota'},
                {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                {data: 'kelas', name: 'kelas'},
                {data: 'sudah', name: 'sudah'},
                {data: 'belum', name: 'belum'},
                {data: 'tahun_pelajaran', name: 'tahun_pelajaran'},
            ]
        });
    });
</script>
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Laporan Pengembalian</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Laporan Pengembalian</div>
    </div>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Filter</h4>
      </div>
      <div class="card-body">
        <div class="col-12">
            <form action="{{ route('laporan.print-pengembalian') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="kelas">Kelas</label>
                        <select class="form-control select2 filter @error('kelas') is-invalid @enderror" style="width: 100%" name="kelas" id="kelas">
                            <option value="" selected>Pilih kelas</option>
                            @foreach ($kelas as $item)
                            <option value="{{ $item->id }}" >{{ $item->kelas }}</option>
                            @endforeach
                        </select>
                        @error('kelas')
                            <span class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label for="tahun_pelajaran">Tahun Pelajaran</label>
                        <select class="form-control select2 filter @error('tahun_pelajaran') is-invalid @enderror" style="width: 100%" name="tahun_pelajaran" id="tahun_pelajaran">
                            <option value="" selected>Pilih tahun pelajaran</option>
                            @foreach ($tahun_pelajaran as $item)
                            <option value="{{ $item->id }}" >{{ $item->tahun }}</option>
                            @endforeach
                        </select>
                        @error('tahun_pelajaran')
                            <span class="invalid-feedback" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-2">
                    <button class="btn btn-primary">Cetak</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="col-12">
            <table id="pengembalian-table" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Sudah</th>
                        <th>Belum</th>
                        <th>Tahun Pelajaran</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
