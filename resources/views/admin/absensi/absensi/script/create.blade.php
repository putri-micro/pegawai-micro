<script>
    let dropdownData = [];

    $('#form_create').on('shown.bs.modal', function () {
        fetchDataDropdown("{{ route('admin.absensi.absensi.dropdown.jadwal') }}", '#id_jadwal_karyawan', 'jadwal_karyawan',
            'nama_jadwal_lengkap', function (data) {
                dropdownData = data;
            });
    });

    $('#id_jadwal_karyawan').on('change', function () {
        const selectedId = $(this).val();
        if (selectedId && dropdownData.length > 0) {
            const selectedItem = dropdownData.find(item => item.id_jadwal_karyawan == selectedId);
            if (selectedItem) {
                $('#id_sdm').val(selectedItem.id_sdm);
            }
        } else {
            $('#id_sdm').val('');
        }
    });

    $('#saveCreate').click(function (e) {
        e.preventDefault();
        var formData = new FormData($("#createForm")[0]);

        Swal.fire({
            title: 'Konfirmasi Simpan',
            text: "Apakah Anda yakin ingin menyimpan data ini?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                DataManager.openLoading();
                DataManager.formData(
                    "{{ route('admin.absensi.absensi.store') }}",
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
                        $('#form_create').modal('hide');
                        $('#createForm')[0].reset();
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