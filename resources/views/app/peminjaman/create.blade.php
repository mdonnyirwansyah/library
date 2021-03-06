@extends('layouts.app')

@section('title', 'Tambah Peminjaman')

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

    $(document).ready( function() {
        $('#tahun_pelajaran').select2({
            theme: 'bootstrap4',
            placeholder: 'Pilih tahun pelajaran',
        });

        $('#buku').select2({
            placeholder: 'Pilih buku',
        });

        $('#nis').change(function (e) {
            let nis = $('#nis').val();

            $.ajax({
                url: "{{ route('anggota.find') }}",
                type: "POST",
                data: {
                    nis
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if(response.success){
                        $('#nis').removeClass('is-invalid');
                        $('#nis').addClass('is-valid');
                        $('.nis_valid').text('Nama Anggota: ' + response.success);
                        $('#btn').attr('disabled', false);
                    }else{
                        $('#nis').removeClass('is-valid');
                        $('#nis').addClass('is-invalid');
                        $('.nis_err').text(response.error);
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
                            setTimeout(function() { resolve('{{ route("peminjaman.index") }}'); }, 3000);
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
            <a href="{{ route('peminjaman.index') }}" class="btn btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1>Tambah Peminjaman</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('peminjaman.index') }}">Peminjaman</a>
            </div>
            <div class="breadcrumb-item">Tambah Peminjaman</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('peminjaman.store') }}" id="form-action" enctype="multipart/form-data">
                            @include('app.peminjaman.partials.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
