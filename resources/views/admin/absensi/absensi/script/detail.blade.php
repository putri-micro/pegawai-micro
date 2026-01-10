<script>
    $('body').on('click', '.detail', function () {
        var id = $(this).data('id');
        $.ajax({
            url: "{{ route('admin.absensi.absensi.show', ':id') }}".replace(':id', id),
            type: 'GET',
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#detail_tanggal').text(data.tanggal);
                    $('#detail_id_sdm').text(data.id_sdm);
                    $('#detail_id_jadwal_karyawan').text(data.id_jadwal_karyawan);
                    $('#detail_total_jam_kerja').text(data.total_jam_kerja);
                    $('#detail_total_terlambat').text(data.total_terlambat);
                    $('#detail_total_pulang_awal').text(data.total_pulang_awal);
                    $('#form_detail').modal('show');
                } else {
                    Swal.fire('Gagal', 'Data tidak ditemukan', 'error');
                }
            },
            error: function (xhr) {
                Swal.fire('Error', 'Gagal mengambil data', 'error');
            }
        });
    });
</script>