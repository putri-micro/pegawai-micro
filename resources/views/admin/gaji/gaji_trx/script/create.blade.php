<script>
    "use strict";
    var KTGajiTrxAdd = function () {
        const t = document.getElementById("form_create");
        const e = t.querySelector("#form_create_data");
        const n = new bootstrap.Modal(t);

        return {
            init: function () {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            transaksi_id: { validators: { notEmpty: { message: "ID Transaksi tidak boleh kosong" } } },
                            periode_id: { validators: { notEmpty: { message: "ID Periode tidak boleh kosong" } } },
                            total_penghasil: { validators: { notEmpty: { message: "Total penghasilan tidak boleh kosong" } } },
                            total_potongan: { validators: { notEmpty: { message: "Total potongan tidak boleh kosong" } } },
                            total_dibayar: { validators: { notEmpty: { message: "Total dibayar tidak boleh kosong" } } },
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
                                        url: "{{ route('admin.gaji.gaji_trx.store') }}",
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content') },
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
                                            let errorMsg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "Maaf, sepertinya ada kesalahan.";
                                            Swal.fire({ text: errorMsg, icon: "error", confirmButtonText: "Ok, mengerti!", customClass: { confirmButton: "btn btn-primary" } });
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
    KTUtil.onDOMContentLoaded((function () { KTGajiTrxAdd.init() }));
</script>
