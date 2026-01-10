<script defer>
    $('#form_create').on('show.bs.modal', function (e) {
        // Fix Select2 in Modal
        $('#id_libur').select2({
            dropdownParent: $('#form_create')
        });

        // Auto-fill nama_jadwal
        $('#id_libur').on('change', function () {
            const selectedText = $(this).find('option:selected').text();
            // Format: "Nama Libur (dd/mm/yyyy)" -> Extract "Nama Libur"
            if (selectedText) {
                const namePart = selectedText.split('(')[0].trim();
                $('#nama_jadwal').val(namePart);
            }
        });

        $('#bt_submit_create').on('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Kamu yakin?',
                text: 'Apakah datanya benar dan apa yang anda inginkan?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                cancelButtonColor: '#dd3333',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                focusCancel: true
            }).then((result) => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        nama_jadwal: $('#nama_jadwal').val(),
                        jam_masuk: $('#jam_masuk').val(),
                        jam_pulang: $('#jam_pulang').val(),
                        istirahat_mulai: $('#istirahat_mulai').val(),
                        istirahat_selesai: $('#istirahat_selesai').val(),
                        toleransi_menit: $('#toleransi_menit').val(),
                        id_libur: $('#id_libur').val(),
                        keterangan: $('#keterangan').val()
                    };
                    const action = '{{ route('admin.master.jadwal-kerja.store') }}';
                    DataManager.postData(action, input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter();
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Warning', 'validasi bermasalah', 'warning');
                        }
                        if (!response.success && !response.errors) {
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
        $m.find('select').val('').trigger('change');
        $m.find('textarea').val('');
        $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
        $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
    });
</script>