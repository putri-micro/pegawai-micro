<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_detail.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#detail_id_detail').text(data.detail_id);
                    $('#komponen_id_detail').text(data.komponen_id);
                    $('#nominal_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.nominal));
                    $('#keterangan_detail').text(data.keterangan || '-');
                    $('#transaksi_id_detail_val').text(data.transaksi_id);
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>