<script>
    $(document).on('click', 'input[name="main_checkbox"]', function () {
        if (this.checked) {
            $('input[name="row_checkbox"]').each(function () {
                this.checked = true;
            })
        } else {
            $('input[name="row_checkbox"]').each(function () {
                this.checked = false;
            });
        }
        btnDeleteCheckbox();
    });

    $(document).on('change', 'input[name="row_checkbox"]', function () {
        if ($('input[name="row_checkbox"]').length == $('input[name="row_checkbox"]:checked').length) {
            $('input[name="main_checkbox"]').prop('checked', true);
        } else {
            $('input[name="main_checkbox"]').prop('checked', false);
        }
        btnDeleteCheckbox();
    });

    $(document).on('click', '#btn-delete-checkbox', function () {
        let rowChecked = [];

        $('input[name="row_checkbox"]:checked').each(function () {
            rowChecked.push($(this).data('id'));
        });

        let route = $(this).data('route');
        let total = rowChecked.length;

        swal({
            title: 'Are you sure?',
            text: 'You want to delete('+total+') record!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $('#btn-delete-checkbox').attr('disabled', true);
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        rowChecked
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('input[name="row_checkbox"]').each(function () {
                            this.checked = false;
                        });
                        $('input[name="main_checkbox"]').prop('checked', false);
                        $('#btn-delete-checkbox').hide();
                        $('#btn-delete-checkbox').attr('disabled', false);
                        $('#user-table').DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal('Your record is safe!');
            }
        });
    });

    $(document).on('change', 'select[name="user-table_length"]', function () {
        $('input[name="row_checkbox"]').each(function () {
            this.checked = false;
        });
        $('input[name="main_checkbox"]').prop('checked', false);
        $('#btn-delete-checkbox').hide();
    });

    $(document).on('click', '.page-link', function () {
        $('input[name="row_checkbox"]').each(function () {
            this.checked = false;
        });
        $('input[name="main_checkbox"]').prop('checked', false);
        $('#btn-delete-checkbox').hide();
    });

    $(document).on('click', 'input[type="search"]', function () {
        $('input[name="row_checkbox"]').each(function () {
            this.checked = false;
        });
        $('input[name="main_checkbox"]').prop('checked', false);
        $('#btn-delete-checkbox').hide();
    });

    function btnDeleteCheckbox() {
        let total = $('input[name="row_checkbox"]:checked').length;

        if (total > 0) {
            $('#btn-delete-checkbox').text("Delete("+total+")").show();
        } else {
            $('#btn-delete-checkbox').hide();
        }
    }

    function printErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            $('#'+key).addClass('is-invalid');
            $('.'+key+'_err').text(value);
        });
    }

    function createRecord() {
        $.get('{{ route("users.create") }}', function (response) {
            $('#view-modal').html(response.success).show();
            $('#modal-form').modal('show');
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select roles',
            });

            $('#form-action').submit(function (e) {
                e.preventDefault();
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
                            $('#user-table').DataTable().draw();
                            $('#modal-form').modal('hide');
                            toastr.success(response.success, 'Congratulations,');
                        }else{
                            printErrorMsg(response.error);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        let errors = jQuery.parseJSON(xhr.responseText);
                        printErrorMsg(errors.errors);
                    }
                });
            });
        });


    }

    function editRecord(id) {
        let route = $('#edit-'+id).attr('edit-route');
        $.get(route, function (response) {
            $('#view-modal').html(response.success).show();
            $('#modal-form').modal('show');
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: 'Select roles',
            });

            $('#form-action').submit(function (e) {
                e.preventDefault();
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
                            $('#user-table').DataTable().draw();
                            $('#modal-form').modal('hide');
                            toastr.success(response.success, 'Congratulations,');
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
    }

    function deleteRecord(id) {
        let route = $('#delete-'+id).attr('delete-route');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: route,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        $('#user-table').DataTable().draw();
                        toastr.success(response.success, 'Congratulations,');
                    },
                });
            } else {
                swal('Your record is safe!');
            }
        });
    }
</script>
