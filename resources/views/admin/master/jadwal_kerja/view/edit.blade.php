<div class="modal fade" id="form_edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Edit Jadwal Kerja</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            </div>
            <form id="bt_submit_edit">
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_edit_user_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}"
                        data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_edit_user_header"
                        data-kt-scroll-wrappers="#kt_modal_edit_user_scroll" data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Nama Jadwal</label>
                            <input type="text" name="nama_jadwal" id="edit_nama_jadwal"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Jadwal Kerja"
                                required />
                        </div>

                        <div class="row mb-7">
                            <div class="col-md-6">
                                <label class="required fw-bold fs-6 mb-2">Jam Masuk</label>
                                <input type="time" name="jam_masuk" id="edit_jam_masuk"
                                    class="form-control form-control-solid mb-3 mb-lg-0" required />
                            </div>
                            <div class="col-md-6">
                                <label class="required fw-bold fs-6 mb-2">Jam Pulang</label>
                                <input type="time" name="jam_pulang" id="edit_jam_pulang"
                                    class="form-control form-control-solid mb-3 mb-lg-0" required />
                            </div>
                        </div>

                        <div class="row mb-7">
                            <div class="col-md-6">
                                <label class="fw-bold fs-6 mb-2">Istirahat Mulai</label>
                                <input type="time" name="istirahat_mulai" id="edit_istirahat_mulai"
                                    class="form-control form-control-solid mb-3 mb-lg-0" />
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold fs-6 mb-2">Istirahat Selesai</label>
                                <input type="time" name="istirahat_selesai" id="edit_istirahat_selesai"
                                    class="form-control form-control-solid mb-3 mb-lg-0" />
                            </div>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Toleransi Keterlambatan (Menit)</label>
                            <input type="number" name="toleransi_menit" id="edit_toleransi_menit" min="0"
                                class="form-control form-control-solid mb-3 mb-lg-0" required />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-bold fs-6 mb-2">Nama Libur</label>
                            <select name="id_libur" id="edit_id_libur" class="form-select form-select-solid"
                                data-control="select2" data-placeholder="Pilih Nama Libur (Opsional)"
                                data-allow-clear="true">
                                <option></option>
                                @foreach($libur as $item)
                                    <option value="{{ $item->id_libur }}">{{ $item->nama_libur }}
                                        ({{ $item->tanggal->format('d/m/Y') }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-bold fs-6 mb-2">Keterangan</label>
                            <textarea name="keterangan" id="edit_keterangan"
                                class="form-control form-control-solid mb-3 mb-lg-0" rows="3"
                                placeholder="Keterangan tambahan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="kt_modal_edit_submit">
                        <span class="indicator-label">Simpan</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>