<script>
    $(document).ready(function () {
        const form = document.querySelector('#form_edit_data');
        const modal = $('#form_edit');

        modal.on('show.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');

            DataManager.fetchData("{{ url('admin/sdm/jadwal-karyawan/show') }}/" + id).then(response => {
                if (response.success) {
                    const data = response.data;
                    $(form).find('input[name="tanggal_mulai"]').val(data.tanggal_mulai);
                    $(form).find('input[name="tanggal_selesai"]').val(data.tanggal_selesai);

                    // Set Select2
                    $(form).find('select[name="id_jadwal_kerja"]').val(data.id_jadwal_kerja).trigger('change');

                    // Update Action URL
                    form.action = "{{ url('admin/sdm/jadwal-karyawan/update') }}/" + id;
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }).catch(error => {
                ErrorHandler.handleError(error);
            });
        });

        $(form).on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            formData.append('_method', 'PUT');

            DataManager.formData(
                form.action,
                formData
            ).then(response => {
                if (response.success) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    modal.modal('hide');
                    refreshTable();
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }).catch(error => {
                ErrorHandler.handleError(error);
            });
        });
    });
</script>