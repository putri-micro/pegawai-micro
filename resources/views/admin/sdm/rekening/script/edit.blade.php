<script defer>
    $("#form_edit").on("show.bs.modal", function (e) {
        const $bankSelect = $("#edit_bank");
        let bankListLoaded = false;
        let pendingBankValue = null;

        const loadBanks = () => {
            return DataManager.fetchData("{{ route('api.ref.bank') }}").then(response => {
                if (response.success) {
                    $bankSelect.empty().append('<option></option>');
                    response.data.forEach(item => {
                        $bankSelect.append(`<option value="${item.nama_bank}" data-kode="${item.kode_swift}">${item.nama_bank}</option>`);
                    });
                    $bankSelect.select2({
                        dropdownParent: $('#form_edit')
                    });
                    bankListLoaded = true;
                    if (pendingBankValue) {
                        $bankSelect.val(pendingBankValue).trigger("change");
                        pendingBankValue = null;
                    }
                }
            });
        };

        loadBanks();

        $("#edit_bank").on("change", function () {
            const selectedOption = $(this).find('option:selected');
            const kodeSwift = selectedOption.data('kode');
            if (kodeSwift && !$("#edit_kode_bank").val()) {
                $("#edit_kode_bank").val(kodeSwift);
            }
        });


        const button = $(e.relatedTarget);
        const id = button.data("id");
        const detail = "{{ route('admin.sdm.rekening.show', ':id') }}";

        DataManager.fetchData(detail.replace(':id', id)).then(response => {
            if (response.success) {
                const data = response.data;
                $("#edit_no_rekening").val(data.no_rekening);
                $("#edit_nama_pemilik").val(data.nama_pemilik);
                $("#edit_kode_bank").val(data.kode_bank);
                $("#edit_cabang_bank").val(data.cabang_bank);
                $("#edit_jenis_rekening").val(data.jenis_rekening).trigger("change");
                $("#edit_status_aktif").val(data.status_aktif).trigger("change");
                $("#edit_rekening_utama").val(data.rekening_utama).trigger("change");

                if (bankListLoaded) {
                    $("#edit_bank").val(data.bank).trigger("change");
                } else {
                    pendingBankValue = data.bank;
                }

            } else {
                Swal.fire("Warning", response.message, "warning");
            }
        })
            .catch(error => {
                ErrorHandler.handleError(error);
            });

        $("#bt_submit_edit").on("submit", function (e) {
            e.preventDefault();

            // Validation for required fields based on controller requirements
            if (!$('#edit_no_rekening').val()) {
                Swal.fire('Warning', 'Nomor rekening wajib diisi', 'warning');
                $('#edit_no_rekening').focus();
                return;
            }
            if ($('#edit_no_rekening').val().length > 25) {
                Swal.fire('Warning', 'Nomor rekening maksimal 25 karakter', 'warning');
                $('#edit_no_rekening').focus();
                return;
            }
            if (!$('#edit_bank').val()) {
                Swal.fire('Warning', 'Nama bank wajib diisi', 'warning');
                $('#edit_bank').focus();
                return;
            }
            if ($('#edit_bank').val().length > 50) {
                Swal.fire('Warning', 'Nama bank maksimal 50 karakter', 'warning');
                $('#edit_bank').focus();
                return;
            }

            // Optional field length validations
            if ($('#edit_nama_pemilik').val() && $('#edit_nama_pemilik').val().length > 100) {
                Swal.fire('Warning', 'Nama pemilik maksimal 100 karakter', 'warning');
                $('#edit_nama_pemilik').focus();
                return;
            }
            if ($('#edit_kode_bank').val() && $('#edit_kode_bank').val().length > 10) {
                Swal.fire('Warning', 'Kode bank maksimal 10 karakter', 'warning');
                $('#edit_kode_bank').focus();
                return;
            }
            if ($('#edit_cabang_bank').val() && $('#edit_cabang_bank').val().length > 100) {
                Swal.fire('Warning', 'Cabang bank maksimal 100 karakter', 'warning');
                $('#edit_cabang_bank').focus();
                return;
            }

            const updateUrl = "{{ route('admin.sdm.rekening.update', ':id') }}".replace(":id", id);
            Swal.fire({
                title: 'Kamu yakin?',
                text: "Apakah datanya benar dan apa yang anda inginkan?",
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#dd3333',
                showCancelButton: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                focusCancel: true,
            }).then(result => {
                if (result.value) {
                    DataManager.openLoading();
                    const input = {
                        "no_rekening": $("#edit_no_rekening").val(),
                        "bank": $("#edit_bank").val(),
                        "nama_pemilik": $("#edit_nama_pemilik").val(),
                        "kode_bank": $("#edit_kode_bank").val(),
                        "cabang_bank": $("#edit_cabang_bank").val(),
                        "jenis_rekening": $("#edit_jenis_rekening").val(),
                        "status_aktif": $("#edit_status_aktif").val(),
                        "rekening_utama": $("#edit_rekening_utama").val(),
                    };

                    DataManager.postData(updateUrl, input).then(response => {
                        if (response.success) {
                            $('#form_edit').modal('hide');
                            Swal.fire({
                                title: 'Success',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: "OK",
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                $('#example').DataTable().ajax.reload();
                            });
                        } else if (response.errors) {
                            const validationErrorFilter = new ValidationErrorFilter(
                                "edit_");
                            validationErrorFilter.filterValidationErrors(response);
                            Swal.fire("Warning", "Validasi bermasalah", "warning");
                        } else {
                            Swal.fire("Warning", response.message, "warning");
                        }
                    })
                        .catch(error => {
                            ErrorHandler.handleError(error);
                        });
                }
            });
        });
    })
        .on("hidden.bs.modal", function () {
            const $m = $(this);
            $m.find('form').trigger('reset');
            $m.find('select, textarea').val('').trigger('change');
            $m.find('.is-invalid, .is-valid').removeClass('is-invalid is-valid');
            $m.find('.invalid-feedback, .valid-feedback, .text-danger').remove();
        });
</script>