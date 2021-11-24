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
                            $('#kategori-table').DataTable().draw();
                            toastr.success(response.success, 'Selamat,');
                        } else {
                            swal(response.failed);
                        }
                    },
                });
            } else {
                swal('Data batal dihapus!');
            }
        });
    }
</script>
