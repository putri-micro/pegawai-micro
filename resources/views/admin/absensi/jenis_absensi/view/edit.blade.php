<div class="modal fade" id="form_edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Edit Jenis Absensi</h2>
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
                <form id="form_edit_data" class="form" action="#">
                    <input type="hidden" name="id" id="id_edit" />
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="modal_edit_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#modal_edit_header" data-kt-scroll-wrappers="#modal_edit_scroll"
                        data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Nama Absen</label>
                            <input type="text" name="nama_absen" id="nama_absen_edit"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nama Absen" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Kategori</label>
                            <select name="kategori" id="kategori_edit" class="form-select form-select-solid"
                                data-control="select2" data-placeholder="Pilih Kategori" data-hide-search="true">
                                <option></option>
                                <option value="NORMAL">NORMAL</option>
                                <option value="TELAT">TELAT</option>
                                <option value="IZIN">IZIN</option>
                                <option value="SAKIT">SAKIT</option>
                                <option value="ALPHA">ALPHA</option>
                                <option value="CUTI">CUTI</option>
                            </select>
                        </div>

                        <div class="fv-row mb-7">
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="1" id="potong_gaji_edit"
                                    name="potong_gaji" />
                                <label class="form-check-label fw-bold" for="potong_gaji_edit">
                                    Potong Gaji
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <span class="indicator-label">Simpan</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>