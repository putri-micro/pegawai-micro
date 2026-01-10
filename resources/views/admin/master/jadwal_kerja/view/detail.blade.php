<div class="modal fade" id="form_detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Detail Jadwal Kerja</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <i class="fas fa-times"></i>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div id="show_data">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-offset="300px">

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Nama Jadwal</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800" id="detail_nama_jadwal"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Jam Kerja</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800" id="detail_jam_kerja"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Jam Istirahat</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800" id="detail_jam_istirahat"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Toleransi</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800" id="detail_toleransi"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Referensi Libur</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800" id="detail_libur"></span>
                            </div>
                        </div>

                        <div class="row mb-7">
                            <label class="col-lg-4 fw-bold text-muted">Keterangan</label>
                            <div class="col-lg-8">
                                <span class="fw-bolder fs-6 text-gray-800" id="detail_keterangan"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="null_data" style="display: none;">
                    <div class="text-center">
                        <h4 class="fw-bold text-danger">Data tidak ditemukan!</h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer flex-center">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>