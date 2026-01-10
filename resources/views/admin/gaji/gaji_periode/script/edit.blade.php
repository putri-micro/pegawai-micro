<script>
    "use strict";
    var KTGajiPeriodeEdit = function () {
        const t = document.getElementById("form_edit");
        const e = t.querySelector("#form_edit_data");
        const n = new bootstrap.Modal(t);

        return {
            init: function () {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            periode_id: {
                                validators: {
                                    notEmpty: {
                                        message: "ID Periode tidak boleh kosong"
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
                                    formData.append('_method', 'PUT');

                                    $.ajax({
                                        url: "{{ route('admin.gaji.gaji_periode.update', ':id') }}".replace(':id', id),
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                                        },
                                        n.hide();
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
        }) ()
    }
        }
    }();

    KTUtil.onDOMContentLoaded((function () {
        KTGajiPeriodeEdit.init()
    }));

    function edit(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_periode.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#id_edit').val(data.id);
                    $('#periode_id_edit').val(data.periode_id);
                    $('#tahun_edit').val(data.tahun);
                    $('#tanggal_mulai_edit').val(data.tanggal_mulai.split('T')[0]);
                    $('#tanggal_selesai_edit').val(data.tanggal_selesai.split('T')[0]);
                    $('#status_edit').val(data.status).trigger('change');

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
                    url: "{{ route('admin.gaji.gaji_periode.destroy', ':id') }}".replace(':id', id),
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            text: "Data berhasil dihapus!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, mengerti!",
                            timer: 1500,
                            timerProgressBar: true,
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
            }
        });
    }
</script>
