<script defer>
    $('#form_detail').on('show.bs.modal', function (e) {
        $(this).attr('aria-hidden', 'false');
        const button = $(e.relatedTarget);
        const id = button.data('id');
        const detail = '{{ route('admin.master.libur.show', [':id']) }}';
        DataManager.fetchData(detail.replace(':id', id))
            .then(function (response) {
                if (response.success) {
                    // Format date for display
                    let tanggalDisplay = '-';
                    if (response.data.tanggal) {
                        const date = new Date(response.data.tanggal);
                        tanggalDisplay = date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });
                    }
                    $('#detail_tanggal').text(tanggalDisplay);
                    $('#detail_jenis_libur').text(response.data.jenis_libur || '-');
                    $('#detail_nama_libur').text(response.data.nama_libur || '-');
                    $('#detail_keterangan').text(response.data.keterangan || '-');
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