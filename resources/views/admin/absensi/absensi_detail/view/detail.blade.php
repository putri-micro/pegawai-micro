<div class="modal fade" id="form_detail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Detail Absensi</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                    <span class="bi bi-x fs-1"></span>
                </div>
            </div>
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <div class="d-flex flex-column mb-7 fv-row">
                    <label class="fs-6 fw-semibold mb-2 text-muted">Tanggal Absensi</label>
                    <div class="fs-5 fw-bold" id="detail_tanggal">-</div>
                </div>

                <div class="d-flex flex-column mb-7 fv-row">
                    <label class="fs-6 fw-semibold mb-2 text-muted">Jenis Absen</label>
                    <div class="fs-5 fw-bold" id="detail_jenis_absen">-</div>
                </div>

                <div class="row g-9 mb-7">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-semibold mb-2 text-muted">Waktu Mulai</label>
                        <div class="fs-5 fw-bold" id="detail_waktu_mulai">-</div>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-semibold mb-2 text-muted">Waktu Selesai</label>
                        <div class="fs-5 fw-bold" id="detail_waktu_selesai">-</div>
                    </div>
                </div>

                <div class="row g-9 mb-7">
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-semibold mb-2 text-muted">Durasi (Jam)</label>
                        <div class="fs-5 fw-bold" id="detail_durasi_jam">-</div>
                    </div>
                    <div class="col-md-6 fv-row">
                        <label class="fs-6 fw-semibold mb-2 text-muted">Lokasi Pulang</label>
                        <div class="fs-5 fw-bold" id="detail_lokasi_pulang">-</div>
                    </div>
                </div>

                <div class="text-center pt-15">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#form_detail').on('show.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');

            DataManager.fetchData("{{ route('admin.absensi.absensi_detail.show', ['id' => ':id']) }}".replace(':id', id))
                .then(response => {
                    if (response.success) {
                        const data = response.data;
                        $('#detail_tanggal').text(data.absensi ? data.absensi.tanggal : '-');
                        $('#detail_jenis_absen').text(data.jenis_absen ? data.jenis_absen.nama_absen : '-');
                        $('#detail_waktu_mulai').text(data.waktu_mulai || '-');
                        $('#detail_waktu_selesai').text(data.waktu_selesai || '-');
                        $('#detail_durasi_jam').text(data.durasi_jam || '0.00');
                        $('#detail_lokasi_pulang').text(data.lokasi_pulang || '-');
                    }
                })
                .catch(error => {
                    ErrorHandler.handleError(error);
                });
        });
    });
</script>