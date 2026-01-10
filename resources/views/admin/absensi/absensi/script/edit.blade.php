<script>
    let editDropdownData = [];

    $('body').on('click', '.edit', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.absensi.absensi.show', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#edit_id').val(data.id_absensi);
                    $('#edit_tanggal').val(data.tanggal);
                    $('#edit_id_sdm').val(data.id_sdm);

                    fetchDataDropdown("{{ route('admin.absensi.absensi.dropdown.jadwal') }}", '#edit_id_jadwal_karyawan', 'jadwal_karyawan', 'nama_jadwal_lengkap', function (dataList) {
                        editDropdownData = dataList;
                        $('#edit_id_jadwal_karyawan').val(data.id_jadwal_karyawan).trigger('change');
                    });

                    $('#edit_total_jam_kerja').val(data.total_jam_kerja);
                    $('#edit_total_terlambat').val(data.total_terlambat);
                    $('#edit_total_pulang_awal').val(data.total_pulang_awal);
                    $('#form_edit').modal('show');
                } else {
                    Swal.fire('Gagal', 'Data tidak ditemukan', 'error');
                }
            },
            error: function (xhr) {
                Swal.fire('Error', 'Gagal mengambil data', 'error');
            }
        });
    });

    $('#edit_id_jadwal_karyawan').on('change', function () {
        const selectedId = $(this).val();
        if (selectedId && editDropdownData.length > 0) {
            const selectedItem = editDropdownData.find(item => item.id_jadwal_karyawan == selectedId);
            if (selectedItem) {
                $('#edit_id_sdm').val(selectedItem.id_sdm);
            }
        }
    });

    $('#saveEdit').click(function (e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        var formData = new FormData($("#editForm")[0]);
        formData.append('_method', 'PUT');

        Swal.fire({
            title: 'Konfirmasi Update',
            text: "Apakah Anda yakin ingin memperbarui data ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Update',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                DataManager.openLoading();
                DataManager.formData(
                    "{{ route('admin.absensi.absensi.update', ':id') }}".replace(':id', id),
                    formData
                ).then(response => {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            $('#form_edit').modal('hide');
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
    });
</script>