<script>
    "use strict";
    var KTGajiJabatanEdit = function () {
        const t = document.getElementById("form_edit");
        const e = t.querySelector("#form_edit_data");
        const n = new bootstrap.Modal(t);

        return {
            init: function () {
                (() => {
                    var o = FormValidation.formValidation(e, {
                        fields: {
                            gaji_master_id: { validators: { notEmpty: { message: "ID Master Gaji tidak boleh kosong" } } },
                            komponen_id: { validators: { notEmpty: { message: "ID Komponen tidak boleh kosong" } } },
                            nominal: { validators: { notEmpty: { message: "Nominal tidak boleh kosong" } } },
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
                                        url: "{{ route('admin.gaji.gaji_jabatan.update', ':id') }}".replace(':id', id),
                                        type: "POST",
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        headers: { 'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content') },
                                        success: function (response) {
                                            submitButton.removeAttribute("data-kt-indicator");
                                            submitButton.disabled = false;
                                            Swal.fire({ text: "Data berhasil diperbarui!", icon: "success", confirmButtonText: "Ok, mengerti!", customClass: { confirmButton: "btn btn-primary" } })
                                                .then((function (t) { if (t.isConfirmed) { n.hide(); $('#example').DataTable().ajax.reload(); } }));
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
    KTUtil.onDOMContentLoaded((function () { KTGajiJabatanEdit.init() }));

    function edit(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_jabatan.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#id_edit').val(data.id);
                    $('#gaji_master_id_edit').val(data.gaji_master_id);
                    $('#komponen_id_edit').val(data.komponen_id);
                    $('#nominal_edit').val(data.nominal);
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
                    url: "{{ route('admin.gaji.gaji_jabatan.destroy', ':id') }}".replace(':id', id),
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
