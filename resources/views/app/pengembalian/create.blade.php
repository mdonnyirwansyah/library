@extends('layouts.app')

@section('title', 'Tambah Pengembalian')

@push('javascript')
<script>
    function printErrorMsg (msg) {
        $.each( msg, function ( key, value ) {
            $('#'+key).addClass('is-invalid');
            $('.'+key+'_err').text(value);
            $('#'+key).change(function () {
                $('#'+key).removeClass('is-invalid');
                $('#'+key).addClass('is-valid');
            });
        });
    }

    function show(id) {
        $.get('http://127.0.0.1:8000/peminjaman/show/'+id, function (response) {
            $('#view-form-buku').html(response.success).show();
        });
    }

    $(document).ready( function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih buku',
        });


        $('#peminjaman_id').change(function (e) {
            let peminjaman_id = $('#peminjaman_id').val();

            $.ajax({
                url: "{{ route('peminjaman.find') }}",
                type: "POST",
                data: {
                    peminjaman_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.success){
                        $('#peminjaman_id').removeClass('is-invalid');
                        $('#peminjaman_id').addClass('is-valid');
                        $('.peminjaman_id_valid').text('Nama Peminjam: ' + response.success);
                        $('#btn').attr('disabled', false);
                        show(response.id);
                    }else{
                        $('#peminjaman_id').removeClass('is-valid');
                        $('#peminjaman_id').addClass('is-invalid');
                        $('.peminjaman_id_err').text(response.error);
                        $('#btn').attr('disabled', true);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError);
                }
            });
        });

        $('#form-action').submit(function (e) {
            e.preventDefault();
            $('#btn').attr('disabled', true);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.success){
                        toastr.success(response.success, 'Selamat,');

                        async function redirect() {
                        let promise = new Promise(function(resolve, reject) {
                            setTimeout(function() { resolve('{{ route("pengembalian.index") }}'); }, 3000);
                        });
                        window.location.href = await promise;
                        }

                        redirect();
                    }else{
                        printErrorMsg(response.error);
                        $('#btn').attr('disabled', false);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError);
                }
            });
        });
    });
</script>
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="{{ route('pengembalian.index') }}" class="btn btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1>Tambah Pengembalian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('pengembalian.index') }}">Pengembalian</a>
            </div>
            <div class="breadcrumb-item">Tambah Pengembalian</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengembalian.store') }}" id="form-action" enctype="multipart/form-data">
                            @include('app.pengembalian.partials.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection