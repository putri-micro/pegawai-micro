<script defer>
    $('#form_edit').on('show.bs.modal', function (e) {
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.master.jadwal-kerja.show', [':id']) }}';

        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    const data = response.data;
                    $('#edit_nama_jadwal').val(data.nama_jadwal);
                    $('#edit_jam_masuk').val(data.jam_masuk ? data.jam_masuk.substring(0, 5) : '');
                    $('#edit_jam_pulang').val(data.jam_pulang ? data.jam_pulang.substring(0, 5) : '');
                    $('#edit_istirahat_mulai').val(data.istirahat_mulai ? data.istirahat_mulai.substring(0, 5) : '');
                    $('#edit_istirahat_selesai').val(data.istirahat_selesai ? data.istirahat_selesai.substring(0, 5) : '');
                    $('#edit_toleransi_menit').val(data.toleransi_menit);
                    $('#edit_keterangan').val(data.keterangan);

                    if (data.id_libur) {
                        $('#edit_id_libur').val(data.id_libur).trigger('change');
                    } else {
                        $('#edit_id_libur').val('').trigger('change');
                    }

                    // Re-init Select2 for Modal context
                    $('#edit_id_libur').select2({
                        dropdownParent: $('#form_edit')
                    });

                    // Auto-fill nama_jadwal logic for edit (optional, but consistent)
                    $('#edit_id_libur').on('change', function () {
                        // Only auto-fill if nama_jadwal is empty or user wants it? 
                        // Let's safe-guard: only if user explicitly changes it? 
                        // But 'change' event fires on load too if we trigger it.
                        // We need to distinguish manual change. 
                        // For simplicy in Edit, let's NOT auto-overwrite unless explicitly clicked?
                        // But usually 'change' fires on programmatic trigger too.
                    });

                    // Bind change AFTER setting initial value to avoid overwriting existing name
                    $('#edit_id_libur').off('change.autofill').on('change.autofill', function (e) {
                        if (e.originalEvent) { // Only on user interaction
                            const selectedText = $(this).find('option:selected').text();
                            if (selectedText) {
                                const namePart = selectedText.split('(')[0].trim();
                                $('#edit_nama_jadwal').val(namePart);
                            }
                        }
                    });
                } else {
                    Swal.fire('Warning', response.message, 'warning');
                }
            }).catch(function (error) {
                ErrorHandler.handleError(error);
            });

        $('#bt_submit_edit').on('submit', function (e) {
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
                        nama_jadwal: $('#edit_nama_jadwal').val(),
                        jam_masuk: $('#edit_jam_masuk').val(),
                        jam_pulang: $('#edit_jam_pulang').val(),
                        istirahat_mulai: $('#edit_istirahat_mulai').val(),
                        istirahat_selesai: $('#edit_istirahat_selesai').val(),
                        toleransi_menit: $('#edit_toleransi_menit').val(),
                        id_libur: $('#edit_id_libur').val(),
                        keterangan: $('#edit_keterangan').val()
                    };
                    const update = '{{ route('admin.master.jadwal-kerja.update', [':id']) }}';
                    DataManager.putData(update.replace(':id', id), input).then(response => {
                        if (response.success) {
                            Swal.fire('Success', response.message, 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        }
                        if (!response.success && response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter('edit_');
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire('Peringatan', 'Isian Anda belum lengkap atau tidak valid.', 'warning');
                        }
                        if (!response.success && !response.errors) {
                            Swal.fire('Warning', response.message, 'warning');
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