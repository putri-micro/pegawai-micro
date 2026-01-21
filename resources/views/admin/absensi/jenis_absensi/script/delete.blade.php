<script>
    function deleteConfirmation(id) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                DataManager.openLoading();
                DataManager.requestApi(
                    "{{ route('admin.absensi.jenis_absensi.destroy', ':id') }}".replace(':id', id),
                    {
                        method: 'DELETE'
                    }
                ).then(response => {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            $('#example').DataTable().ajax.reload();
                        });
                    } else {
                        Swal.fire('Gagal', response.message, 'error');
                    }
                }).catch(error => {
                    ErrorHandler.handleError(error);
                });
            }
        });
    }
</script>