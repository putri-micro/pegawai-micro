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
                const url = "{{ url('admin/sdm/jadwal-karyawan/destroy') }}/" + id;
                DataManager.deleteData(url).then(response => {
                    if (response.success) {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.message,
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        refreshTable();
                    } else {
                        Swal.fire('Error', response.message, 'error');
                    }
                }).catch(error => {
                    ErrorHandler.handleError(error);
                });
            }
        });
    }
</script>