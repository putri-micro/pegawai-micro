<script>
    "use strict";
    var KTTarifLemburAdd = function () {
        const t = document.getElementById("form_create");
        const e = t.querySelector("#form_create_data");
        const n = new bootstrap.Modal(t);

        return {
            init: function () {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            tarif_id: { validators: { notEmpty: { message: "ID Tarif tidak boleh kosong" } } },
                            jenis_lembur: { validators: { notEmpty: { message: "Jenis Lembu tidak boleh kosong" } } },
                            tarif_per_jam: { validators: { notEmpty: { message: "Tarif per Jam tidak boleh kosong" } } },
                            berlaku_mulai: { validators: { notEmpty: { message: "Tanggal berlaku tidak boleh kosong" } } },
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
                                        url: "{{ route('admin.gaji.tarif_lembur.store') }}",
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content') },
                                        success: function (response) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;
                                            Swal.fire({ text: "Data berhasil disubmit!", icon: "success", confirmButtonText: "Ok, mengerti!", customClass: { confirmButton: "btn btn-primary" } })
                                                .then((function (t) { if (t.isConfirmed) { n.hide(); e.reset(); $('#example').DataTable().ajax.reload(); } }));
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
    KTUtil.onDOMContentLoaded((function () { KTTarifLemburAdd.init() }));
</script>
