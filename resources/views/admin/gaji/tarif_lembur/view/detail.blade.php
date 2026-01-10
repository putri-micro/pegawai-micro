<div class="modal fade" id="modal_detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Detail Tarif Lembur</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3137)" fill="black" />
                            <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                fill="black" />
                        </svg>
                    </span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal_detail_scroll" data-kt-scroll="true"
                    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#modal_detail_header" data-kt-scroll-wrappers="#modal_detail_scroll"
                    data-kt-scroll-offset="300px">

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">ID Tarif</label>
                        <div id="tarif_id_detail" class="text-gray-800 fs-6 fw-bolder"></div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">Jenis Lembur</label>
                        <div id="jenis_lembur_detail" class="text-gray-800 fs-6 fw-bolder"></div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">Tarif per Jam</label>
                        <div id="tarif_per_jam_detail" class="text-gray-800 fs-6 fw-bolder"></div>
                    </div>

                    <div class="fv-row mb-7">
                        <label class="fw-bold fs-6 mb-2">Berlaku Mulai</label>
                        <div id="berlaku_mulai_detail" class="text-gray-800 fs-6 fw-bolder"></div>
                    </div>

                </div>
                <div class="text-center pt-15">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>