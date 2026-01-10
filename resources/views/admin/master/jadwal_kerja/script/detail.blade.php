<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.master.jadwal-kerja.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    const data = response.data;
                    $('#detail_nama_jadwal').text(data.nama_jadwal);
                    $('#detail_jam_kerja').text((data.jam_masuk ? data.jam_masuk.substring(0, 5) : '-') + ' s/d ' + (data.jam_pulang ? data.jam_pulang.substring(0, 5) : '-'));

                    let istirahat = '-';
                    if (data.istirahat_mulai && data.istirahat_selesai) {
                        istirahat = data.istirahat_mulai.substring(0, 5) + ' s/d ' + data.istirahat_selesai.substring(0, 5);
                    }
                    $('#detail_jam_istirahat').text(istirahat);

                    $('#detail_toleransi').text(data.toleransi_menit + ' Menit');
                    $('#detail_libur').text(data.libur ? data.libur.nama_libur : '-');
                    $('#detail_keterangan').text(data.keterangan || '-');

                    $('#null_data').hide();
                    $('#show_data').show();
                } else {
                    $('#null_data').show();
                    $('#show_data').hide();
                    Swal.fire('Peringatan', response.message, 'warning');
                }
            }).catch(function (error) {
                ErrorHandler.handleError(error);
            });
    });
</script>