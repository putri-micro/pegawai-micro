<script>
    $(document).ready(function () {
        const form = document.querySelector('#form_create_data');
        const modal = document.querySelector('#form_create');
        const submitButton = form.querySelector('[data-kt-users-modal-action="submit"]');

        $(form).on('submit', function (e) {
            e.preventDefault();
            submitButton.setAttribute('data-kt-indicator', 'on');
            submitButton.disabled = true;

            DataManager.formData(
                "{{ route('admin.absensi.absensi_detail.store') }}",
                new FormData(this)
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
                    form.reset();
                    // Reset Select2
                    $(form).find('select').val(null).trigger('change');
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