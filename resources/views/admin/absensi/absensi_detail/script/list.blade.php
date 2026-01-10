<script>
    $(document).ready(function () {
        let table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.absensi.absensi_detail.list') }}",
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal',
                    name: 'tanggal'
                },
                {
                    data: 'jenis_absen_name',
                    name: 'jenis_absen_name'
                },
                {
                    data: 'waktu_mulai',
                    name: 'waktu_mulai'
                },
                {
                    data: 'waktu_selesai',
                    name: 'waktu_selesai'
                },
                {
                    data: 'durasi_jam',
                    name: 'durasi_jam'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-end'
                },
            ],
            order: [[1, 'desc']]
        });

        window.refreshTable = function () {
            table.ajax.reload();
        }

        window.deleteConfirmation = function (id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    DataManager.deleteData("{{ route('admin.absensi.absensi_detail.destroy', ['id' => ':id']) }}".replace(':id', id))
                        .then(response => {
                            if (response.success) {
                                Swal.fire('Berhasil!', response.message, 'success');
                                refreshTable();
                            } else {
                                Swal.fire('Gagal!', response.message, 'error');
                            }
                        })
                        .catch(error => {
                            ErrorHandler.handleError(error);
                        });
                }
            })
        }
    });
</script>