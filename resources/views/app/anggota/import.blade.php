@extends('layouts.app')

@section('title', 'Import Anggota')

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
                            setTimeout(function() { resolve('{{ route("anggota.index") }}'); }, 3000);
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
            <a href="{{ route('anggota.index') }}" class="btn btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1>Import Anggota</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('anggota.index') }}">Anggota</a>
            </div>
            <div class="breadcrumb-item">Import Anggota</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('anggota.store') }}" id="form-action" enctype="multipart/form-data">
                            <input type="hidden" name="import" value="1">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3" for="file">File</label>
                                <div class="col-sm-12 col-md-7">
                                  <input type="file" name="file" id="file">
                                  <small class="invalid-feedback file_err"></small>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                              <div class="col-sm-12 col-md-7">
                                <button class="btn btn-primary" id="btn">Submit</button>
                              </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
