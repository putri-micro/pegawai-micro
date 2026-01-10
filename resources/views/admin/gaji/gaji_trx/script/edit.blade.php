<script>
    "use strict";
    var KTGajiTrxEdit = function () {
        const t = document.getElementById("form_edit");
        const e = t.querySelector("#form_edit_data");
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
                                    var id = $('#id_edit').val();
                                    formData.append('_method', 'PUT');

                                    $.ajax({
                                        url: "{{ route('admin.gaji.gaji_trx.update', ':id') }}".replace(':id', id),
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content') },
                                        success: function (response) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;
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
    KTUtil.onDOMContentLoaded((function () { KTGajiTrxEdit.init() }));

    function edit(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_trx.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#id_edit').val(data.id);
                    $('#transaksi_id_edit').val(data.transaksi_id);
                    $('#periode_id_edit').val(data.periode_id);
                    $('#total_penghasil_edit').val(data.total_penghasil);
                    $('#total_potongan_edit').val(data.total_potongan);
                    $('#total_dibayar_edit').val(data.total_dibayar);
                    $('#id_sdm_edit').val(data.id_sdm);
                    $('#form_edit').modal('show');
                }
            }
        });
    }

    function deleteData(id) {
        Swal.fire({
            text: "Apakah Anda yakin ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Tidak, batalkan",
            customClass: { confirmButton: "btn btn-danger", cancelButton: "btn btn-active-light" }
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    url: "{{ route('admin.gaji.gaji_trx.destroy', ':id') }}".replace(':id', id),
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content') },
                    success: function (response) {
                        Swal.fire({ text: "Data berhasil dihapus!", icon: "success", confirmButtonText: "Ok, mengerti!", customClass: { confirmButton: "btn btn-primary" } })
                            .then(function () { $('#example').DataTable().ajax.reload(); });
                    }
                });
            }
        });
    }
</script>
