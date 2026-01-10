<script>
    $(document).ready(function () {
        const form = document.querySelector('#form_edit_data');
        const modal = document.querySelector('#form_edit');
        const submitButton = form.querySelector('[data-kt-users-modal-action="submit"]');

        $('#form_edit').on('show.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');

            DataManager.fetchData("{{ route('admin.absensi.absensi_detail.show', ['id' => ':id']) }}".replace(':id', id))
                .then(response => {
                    if (response.success) {
                        const data = response.data;
                        $('#edit_id').val(data.id_detail);
                        $('#edit_id_absensi').val(data.id_absensi).trigger('change');
                        $('#edit_id_jenis_absen').val(data.id_jenis_absen).trigger('change');

                        // Format datetime for input
                        if (data.waktu_mulai) {
                            $('#edit_waktu_mulai').val(data.waktu_mulai.replace(' ', 'T').substring(0, 16));
                        }
                        if (data.waktu_selesai) {
                            $('#edit_waktu_selesai').val(data.waktu_selesai.replace(' ', 'T').substring(0, 16));
                        }

                        $('#edit_durasi_jam').val(data.durasi_jam);
                        $('#edit_lokasi_pulang').val(data.lokasi_pulang);
                    }
                })
                .catch(error => {
                    ErrorHandler.handleError(error);
                });
        });

        $(form).on('submit', function (e) {
            e.preventDefault();
            const id = $('#edit_id').val();
            submitButton.setAttribute('data-kt-indicator', 'on');
            submitButton.disabled = true;

            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            DataManager.formData(
                "{{ route('admin.absensi.absensi_detail.update', ['id' => ':id']) }}".replace(':id', id),
                formData
            ).then(response => {
                if (response.success) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                    $(modal).modal('hide');
                    refreshTable();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }).catch(error => {
                ErrorHandler.handleError(error);
            }).finally(() => {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            });
        });
    });
</script>