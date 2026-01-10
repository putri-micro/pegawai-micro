<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_trx.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#transaksi_id_detail').text(data.transaksi_id);
                    $('#periode_id_detail').text(data.periode_id);
                    $('#total_penghasil_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_penghasil));
                    $('#total_potongan_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_potongan));
                    $('#total_dibayar_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.total_dibayar));
                    $('#id_sdm_detail').text(data.id_sdm || '-');
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>