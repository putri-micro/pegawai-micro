<script>
    "use strict";
    var KTUsersAddUser = function () {
        const t = document.getElementById("form_create");
        const e = t.querySelector("#form_create_data");
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
                    const i = t.querySelector('[data-kt-users-modal-action="submit"]');
                    e.addEventListener("submit", (function (t) {
                        t.preventDefault();
                        if (o) {
                            o.validate().then((function (t) {
                                console.log("validated!");
                                if ("Valid" == t) {
                                    const submitButton = e.querySelector('button[type="submit"]');
                                    submitButton.setAttribute("data-kt-indicator", "on");
                                    submitButton.disabled = true;

                                    var formData = new FormData(e);

                                    // Handle checkbox manually if not checked (optional, but typical form behavior handles it or Request validates nullable)
                                    // But FormData usually handles it.

                                    $.ajax({
                                        url: "{{ route('admin.absensi.jenis_absensi.store') }}",
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
                                            Swal.fire({
                                                text: "Data berhasil disubmit!",
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
                                            // Handle validation errors from backend
                                            let errorMsg = "Maaf, sepertinya ada kesalahan, silahkan coba lagi.";
                                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                                errorMsg = xhr.responseJSON.message;
                                            }
                                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                                // Could list errors here
                                                console.log(xhr.responseJSON.errors);
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
        KTUsersAddUser.init()
    }));
</script>
