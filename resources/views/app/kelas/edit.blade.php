@extends('layouts.app')

@section('title', 'Edit Kelas')

@push('javascript')
<script>
    function printErrorMsg (msg) {
        $.each( msg, function ( key, value ) {
            $('#'+key).addClass('is-invalid');
            $('#thumbnail-input').addClass('is-invalid');
            $('.'+key+'_err').text(value);
            $('#'+key).change(function () {
                $('#'+key).removeClass('is-invalid');
                $('#thumbnail-input').removeClass('is-invalid');
                $('#'+key).addClass('is-valid');
            } );
        });
    }

    $(document).ready( function() {
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
                            setTimeout(function() { resolve('{{ route("kelas.index") }}'); }, 3000);
                        });
                        window.location.href = await promise;
                        }

                        redirect();
                    }else{
                        printErrorMsg(response.error);
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
            <a href="{{ route('kelas.index') }}" class="btn btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1>Edit Kelas</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('kelas.index') }}">Kelas</a>
            </div>
            <div class="breadcrumb-item">Edit Kelas</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kelas.update', $kelas) }}" id="form-action" enctype="multipart/form-data">
                            @method('PUT')
                            @include('app.kelas.partials.form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
