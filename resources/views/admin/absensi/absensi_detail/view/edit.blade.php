<div class="modal fade" id="form_edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Edit Detail Absensi</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="bi bi-x fs-1"></span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form id="form_edit_data" class="form" action="#">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Absensi (Tanggal)</span>
                        </label>
                        <select name="id_absensi" id="edit_id_absensi" class="form-select form-select-solid"
                            data-control="select2" data-placeholder="Pilih Absensi" data-dropdown-parent="#form_edit">
                            <option></option>
                        </select>
                    </div>

                    <div class="d-flex flex-column mb-7 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">Jenis Absen</span>
                        </label>
                        <select name="id_jenis_absen" id="edit_id_jenis_absen" class="form-select form-select-solid"
                            data-control="select2" data-placeholder="Pilih Jenis Absen"
                            data-dropdown-parent="#form_edit">
                            <option></option>
                        </select>
                    </div>

                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control form-control-solid" name="waktu_mulai"
                                id="edit_waktu_mulai" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control form-control-solid" name="waktu_selesai"
                                id="edit_waktu_selesai" />
                        </div>
                    </div>

                    <div class="row g-9 mb-7">
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Durasi (Jam)</label>
                            <input type="number" step="0.01" class="form-control form-control-solid" name="durasi_jam"
                                id="edit_durasi_jam" placeholder="0.00" />
                        </div>
                        <div class="col-md-6 fv-row">
                            <label class="fs-6 fw-semibold mb-2">Lokasi Pulang</label>
                            <input type="text" class="form-control form-control-solid" name="lokasi_pulang"
                                id="edit_lokasi_pulang" placeholder="Lokasi Pulang" />
                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">Update</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>