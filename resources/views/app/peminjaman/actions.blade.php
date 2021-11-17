<script>
    function deleteRecord(id) {
        let route = $('#delete-'+id).attr('delete-route');
        swal({
            title: 'Apakah kamu yakin?',
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
                        if (response.success) {
                            $('#peminjaman-table').DataTable().draw();
                            toastr.success(response.success, 'Selamat,');
                        } else {
                            swal(response.failed);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + '\n' + xhr.responseText + '\n' + thrownError);
                    }
                });
            } else {
                swal('Data batal dihapus!');
            }
        });
    }
</script>
