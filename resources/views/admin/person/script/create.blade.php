<script defer>
    $('#form_create').on('show.bs.modal', function (e) {

        // --- Flatpickr untuk tanggal lahir ---
        $('#tanggal_lahir').flatpickr({
            dateFormat: 'Y-m-d',
            altFormat: 'd/m/Y',
            allowInput: false,
            altInput: true,
        });

        // --- Ambil data provinsi ---
        fetchDataDropdown("{{ route('api.almt.provinsi') }}", "#id_provinsi", "id_provinsi", "provinsi");

        // --- Saat provinsi berubah ---
        $('#id_provinsi').off('change').on('change', function () {
            const provinsiId = $(this).val();
            $('#id_kabupaten').empty().append('<option value="">-- Pilih Kabupaten/Kota --</option>');
            $('#id_kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (provinsiId) {
                const kabupatenUrl = "{{ route('api.almt.kabupaten', ':id') }}".replace(':id', provinsiId);
                fetchDataDropdown(kabupatenUrl, '#id_kabupaten', 'id_kabupaten', 'kabupaten');
            }
        });

        // --- Saat kabupaten berubah ---
        $('#id_kabupaten').off('change').on('change', function () {
            const kabupatenId = $(this).val();
            $('#id_kecamatan').empty().append('<option value="">-- Pilih Kecamatan --</option>');
            $('#id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kabupatenId) {
                const kecamatanUrl = "{{ route('api.almt.kecamatan', ':id') }}".replace(':id', kabupatenId);
                fetchDataDropdown(kecamatanUrl, '#id_kecamatan', 'id_kecamatan', 'kecamatan');
            }
        });

        // --- Saat kecamatan berubah ---
        $('#id_kecamatan').off('change').on('change', function () {
            const kecamatanId = $(this).val();
            $('#id_desa').empty().append('<option value="">-- Pilih Desa/Kelurahan --</option>');

            if (kecamatanId) {
                const desaUrl = "{{ route('api.almt.desa', ':id') }}".replace(':id', kecamatanId);
                fetchDataDropdown(desaUrl, '#id_desa', 'id_desa', 'desa');
            }
        });

        // --- Submit form ---
        $('#bt_submit_create').off('submit').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan sudah sesuai?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                allowOutsideClick: false,
                allowEscapeKey: false,
                focusCancel: true,
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const formData = new FormData();
                    formData.append('nama_lengkap', $('#nama_lengkap').val());
                    formData.append('nama_panggilan', $('#nama_panggilan').val());
                    formData.append('jk', $('#jk').val());
                    formData.append('tempat_lahir', $('#tempat_lahir').val());
                    formData.append('tanggal_lahir', $('#tanggal_lahir').val());
                    formData.append('kewarganegaraan', $('#kewarganegaraan').val());
                    formData.append('golongan_darah', $('#golongan_darah').val());
                    formData.append('nik', $('#nik').val());
                    formData.append('agama', $('#agama').val());
                    formData.append('kk', $('#kk').val());
                    formData.append('alamat', $('#alamat').val());
                    formData.append('rt', $('#rt').val());
                    formData.append('rw', $('#rw').val());
                    formData.append('id_desa', $('#id_desa').val());
                    formData.append('npwp', $('#npwp').val());
                    formData.append('no_hp', $('#no_hp').val());
                    formData.append('email', $('#email').val());

                    const fileInput = $('#foto')[0];
                    if (fileInput.files.length > 0) {
                        formData.append('foto', fileInput.files[0]);
                    }

                    const action = "{{ route('admin.person.store') }}";
                    DataManager.formData(action, formData).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Warning', 'Validasi bermasalah', 'warning');
                        } else {
                            Swal.fire('Peringatan', response.message, 'warning');
                        }
                    }).catch(error => {
                        ErrorHandler.handleError(error);
                    });
                }
            });
        });

    }).on('hidden.bs.modal', function () {
        const $m = $(this);
        $m.find('form').trigger('reset');
        $m.find('select, textarea').val('').trigger('change');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });

    // --- Fungsi ambil data dropdown umum ---
    function fetchDataDropdown(url, selector, valueField, textField) {
        $.get(url, function (response) {
            const $dropdown = $(selector);
            $dropdown.empty().append('<option value="">-- Pilih --</option>');
            if (response.success && response.data) {
                response.data.forEach(item => {
                    $dropdown.append(<option value="${item[valueField]}">${item[textField]}</option>);
                });
            }
        }).fail((xhr) => {
            console.error('Gagal memuat data dari:', url);
            console.error(xhr.responseText);
        });
    }
</script>