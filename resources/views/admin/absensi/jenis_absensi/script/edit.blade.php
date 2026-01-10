<script>
    "use strict";
    var KTUsersEditUser = function () {
        const t = document.getElementById("form_edit");
        const e = t.querySelector("#form_edit_data");
        const n = new bootstrap.Modal(t);

        return {
            init: function () {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            nama_absen: {
                                validators: {
                                    notEmpty: {
                                        message: "Nama Absen tidak boleh kosong"
                                    }
                                }
                            },
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger,
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: ".fv-row",
                                eleInvalidClass: "",
                                eleValidClass: ""
                            })
                        }
                    });

                    e.addEventListener("submit", (function (t) {
                        t.preventDefault();
                        if (o) {
                            o.validate().then((function (t) {
                                if ("Valid" == t) {
                                    const submitButton = e.querySelector('button[type="submit"]');
                                    submitButton.setAttribute("data-kt-indicator", "on");
                                    submitButton.disabled = true;

                                    var formData = new FormData(e);
                                    var id = $('#id_edit').val();

                                    // Laravel PUT method spoofing
                                    formData.append('_method', 'PUT');

                                    $.ajax({
                                        url: "{{ route('admin.absensi.jenis_absensi.update', ':id') }}".replace(':id', id),
                                        type: "POST", // Use POST with _method=PUT
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                                        },
                                        success: function (response) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;
                                            n.hide();
                                            e.reset();
                                            Swal.fire({
                                                text: "Data berhasil diperbarui!",
                                                icon: "success",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, mengerti!",
                                                timer: 1500,
                                                timerProgressBar: true,
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            }).then((function (t) {
                                                $('#example').DataTable().ajax.reload();
                                            }));
                                        },
                                        error: function (xhr) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;
                                            let errorMsg = "Maaf, sepertinya ada kesalahan, silahkan coba lagi.";
                                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                                errorMsg = xhr.responseJSON.message;
                                            }

                                            Swal.fire({
                                                text: errorMsg,
                                                icon: "error",
                                                buttonsStyling: false,
                                                confirmButtonText: "Ok, mengerti!",
                                                customClass: {
                                                    confirmButton: "btn btn-primary"
                                                }
                                            });
                                        }
                                    });
                                }
                            }))
                        }
                    }))
                })()
            }
        }
    }();

    KTUtil.onDOMContentLoaded((function () {
        KTUsersEditUser.init()
    }));

    function edit(id) {
        $.ajax({
            url: "{{ route('admin.absensi.jenis_absensi.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#id_edit').val(data.id_jenis_absen);
                    $('#nama_absen_edit').val(data.nama_absen);
                    $('#kategori_edit').val(data.kategori).trigger('change');

                    if (data.potong_gaji == 1) {
                        $('#potong_gaji_edit').prop('checked', true);
                    } else {
                        $('#potong_gaji_edit').prop('checked', false);
                    }

                    $('#form_edit').modal('show');
                }
            },
            error: function (xhr) {
                Swal.fire({
                    text: "Gagal mengambil data",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }

    function deleteData(id) {
        Swal.fire({
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            buttonsStyling: false,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan",
            customClass: {
                confirmButton: "btn btn-danger",
                cancelButton: "btn btn-active-light"
            }
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: "{{ route('admin.absensi.jenis_absensi.destroy', ':id') }}".replace(':id', id),
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            text: "Data berhasil dihapus!.",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function () {
                            $('#example').DataTable().ajax.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire({
                            text: "Gagal menghapus data",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            } else if (result.dismiss === 'cancel') {
                // Do nothing
            }
        });
    }
</script>
