<script>
    $(document).ready(function () {
        $('#form_detail').on('show.bs.modal', function (e) {
            const button = $(e.relatedTarget);
            const id = button.data('id');

            DataManager.fetchData("{{ url('admin/sdm/jadwal-karyawan/show') }}/" + id).then(response => {
                if (response.success) {
                    const data = response.data;
                    $('#nama_jadwal_detail').text(data.jadwal_kerja.nama_jadwal);
                    $('#jam_kerja_detail').text(data.jadwal_kerja.jam_masuk + ' - ' + data.jadwal_kerja.jam_pulang);
                    $('#tanggal_mulai_detail').text(data.tanggal_mulai);
                    $('#tanggal_selesai_detail').text(data.tanggal_selesai || '-');
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            }).catch(error => {
                ErrorHandler.handleError(error);
            });
        });
    });
</script>