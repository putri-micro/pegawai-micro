<script>
    $(document).ready(function () {
        const form = document.querySelector('#form_create_data');
        const modal = document.querySelector('#form_create');
        const submitButton = form.querySelector('[data-kt-users-modal-action="submit"]');

        $(form).on('submit', function (e) {
            e.preventDefault();
            DataManager.formData(
                "{{ route('admin.sdm.jadwal-karyawan.store') }}",
                new FormData(this)
            ).then(response => {
                if (response.success) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: response.message,
                        icon: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $(modal).modal('hide');
                    form.reset();
                    // Reset Select2
                    $(form).find('select').val(null).trigger('change');
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