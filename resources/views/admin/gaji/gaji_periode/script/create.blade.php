<script>
    "use strict";
    var KTGajiPeriodeAdd = function () {
        const t = document.getElementById("form_create");
        const e = t.querySelector("#form_create_data");
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
                            tahun: {
                                validators: {
                                    notEmpty: {
                                        message: "Tahun tidak boleh kosong"
                                    }
                                }
                            },
                            tanggal_mulai: {
                                validators: {
                                    notEmpty: {
                                        message: "Tanggal mulai tidak boleh kosong"
                                    }
                                }
                            },
                            tanggal_selesai: {
                                validators: {
                                    notEmpty: {
                                        message: "Tanggal selesai tidak boleh kosong"
                                    }
                                }
                            },
                            status: {
                                validators: {
                                    notEmpty: {
                                        message: "Status tidak boleh kosong"
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

                                    $.ajax({
                                        url: "{{ route('admin.gaji.gaji_periode.store') }}",
                                        type: "POST",
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
                                            $('#example').DataTable().ajax.reload();
                                            Swal.fire({
                                                toast: true,
                                                position: 'top-end',
                                                icon: 'success',
                                                title: "Data berhasil disubmit!",
                                                showConfirmButton: false,
                                                timer: 2000,
                                                timerProgressBar: true
                                            });
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
        KTGajiPeriodeAdd.init()
    }));
</script>
