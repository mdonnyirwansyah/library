@extends('layouts.app')

@section('title', 'Laporan Anggota')

@push('javascript')
<script>
    $(document).ready( function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih kelas',
        });


        $('.filter').change(function (e) {
            anggota.draw();
            e.preventDefault();
        });

        var anggota = $('#anggota-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('laporan.get-anggota') }}",
                type: "POST",
                data: function (d) {
                    d.kelas_id = $('#kelas_id').val();
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
                {data: 'nis', name: 'nis'},
                {data: 'nama', name: 'nama'},
                {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                {data: 'kelas', name: 'kelas'},
            ]
        });
    });
</script>
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Laporan Anggota</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Laporan Anggota</div>
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
                        <option value="{{ $item->id }}" >{{ $item->nama }}</option>
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
            <table id="anggota-table" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
