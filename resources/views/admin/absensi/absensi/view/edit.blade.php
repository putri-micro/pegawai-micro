<div class="modal fade" id="form_edit" tabindex="-1" aria-hidden="true" data-bs-keyboard="false"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Data Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0">
                <form id="editForm">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_tanggal" class="form-label required">Tanggal</label>
                            <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_id_sdm" class="form-label required">ID SDM</label>
                            <input type="number" class="form-control" id="edit_id_sdm" name="id_sdm" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_id_jadwal_karyawan" class="form-label required">Jadwal Karyawan</label>
                            <select class="form-select" id="edit_id_jadwal_karyawan" name="id_jadwal_karyawan" required
                                data-control="select2" data-dropdown-parent="#form_edit"
                                data-placeholder="Pilih Jadwal Karyawan">
                                <option></option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_total_jam_kerja" class="form-label">Total Jam Kerja</label>
                            <input type="number" class="form-control" id="edit_total_jam_kerja" name="total_jam_kerja"
                                step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_total_terlambat" class="form-label">Total Terlambat</label>
                            <input type="number" class="form-control" id="edit_total_terlambat" name="total_terlambat"
                                step="0.01">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_total_pulang_awal" class="form-label">Total Pulang Awal</label>
                            <input type="number" class="form-control" id="edit_total_pulang_awal"
                                name="total_pulang_awal" step="0.01">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveEdit">Simpan</button>
            </div>
        </div>
    </div>
</div>