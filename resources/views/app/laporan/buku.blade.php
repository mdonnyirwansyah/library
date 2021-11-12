@extends('layouts.app')

@section('title', 'Laporan Buku')

@push('javascript')
<script>
    $(document).ready( function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih kategori',
        });


        $('.filter').change(function (e) {
            buku.draw();
            e.preventDefault();
        });

        var buku = $('#buku-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('laporan.get-buku') }}",
                type: "POST",
                data: function (d) {
                    d.kategori_id = $('#kategori_id').val();
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
                {data: 'judul', name: 'judul'},
                {data: 'kategori', name: 'kategori'},
            ]
        });
    });
</script>
@endpush

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Laporan Buku</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Laporan Buku</div>
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
                    <label for="kategori_id">Kategori</label>
                    <select class="form-control select2 filter" style="width: 100%" name="kategori_id" id="kategori_id">
                        <option value="" selected>Pilih kategori</option>
                        @foreach ($kategori as $item)
                        <option value="{{ $item->id }}" >{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-2">
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
            <table id="buku-table" class="table table-bordered table-striped dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                    </tr>
                </thead>
            </table>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
