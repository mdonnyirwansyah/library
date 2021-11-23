@extends('layouts.app')

@section('title', 'Laporan Peminjaman')

@push('javascript')
<script>
    $(document).ready( function() {
        $('#kelas_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih kelas',
        });

        $('#tahun_pelajaran_id').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih tahun pelajaran',
        });

        $('.filter').change(function (e) {
            peminjaman.draw();
            e.preventDefault();
        });

        var peminjaman = $('#peminjaman-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('laporan.get-peminjaman') }}",
                type: "POST",
                data: function (d) {
                    d.kelas_id = $('#kelas_id').val();
                    d.tahun_pelajaran_id = $('#tahun_pelajaran_id').val();
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
                {data: 'buku', name: 'buku'},
                {data: 'tahun_pelajaran', name: 'tahun_pelajaran'},
            ]
        });
    });
</script>
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Laporan Peminjaman</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Laporan Peminjaman</div>
    </div>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Filter</h4>
      </div>
      <div class="card-body">
        <div class="col-12">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="kelas_id">Kelas</label>
                    <select class="form-control select2 filter" style="width: 100%" name="kelas_id" id="kelas_id">
                        <option value="" selected>Pilih kelas</option>
                        @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" >{{ $item->kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="tahun_pelajaran_id">Tahun Pelajaran</label>
                    <select class="form-control select2 filter" style="width: 100%" name="tahun_pelajaran_id" id="tahun_pelajaran_id">
                        <option value="" selected>Pilih tahun pelajaran</option>
                        @foreach ($tahun_pelajaran as $item)
                        <option value="{{ $item->id }}" >{{ $item->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-2">
              <a href="#" class="btn btn-primary">Cetak</a>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="col-12">
            <table id="peminjaman-table" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Buku</th>
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
