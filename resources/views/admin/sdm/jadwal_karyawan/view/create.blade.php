<div class="modal fade" id="form_create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bolder">Tambah Jadwal Karyawan</h2>
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
                <form id="form_create_data" class="form" action="{{ route('admin.sdm.jadwal-karyawan.store') }}">
                    @csrf
                    <input type="hidden" name="uuid_person" value="{{ $id }}">
                    <div class="d-flex flex-column scroll-y me-n7 pe-7" id="form_create_scroll" data-kt-scroll="true"
                        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#form_create_header" data-kt-scroll-wrappers="#form_create_scroll"
                        data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Jadwal Kerja v2.0</label>
                            <select name="id_jadwal_kerja" class="form-select form-select-solid" data-control="select2"
                                data-placeholder="Pilih Jadwal Kerja">
                                <option></option>
                                @foreach ($jadwalKerja as $jadwal)
                                    <option value="{{ $jadwal->id_jadwal_kerja }}">{{ $jadwal->nama_jadwal }}
                                        ({{ $jadwal->jam_masuk }} - {{ $jadwal->jam_pulang }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="fv-row mb-7">
                            <label class="required fw-bold fs-6 mb-2">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai"
                                class="form-control form-control-solid mb-3 mb-lg-0" />
                        </div>

                        <div class="fv-row mb-7">
                            <label class="fw-bold fs-6 mb-2">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai"
                                class="form-control form-control-solid mb-3 mb-lg-0" />
                        </div>

                    </div>
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
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