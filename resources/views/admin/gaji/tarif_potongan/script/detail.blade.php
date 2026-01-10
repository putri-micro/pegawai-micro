<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.tarif_potongan.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#potongan_id_detail').text(data.potongan_id);
                    $('#nama_potongan_detail').text(data.nama_potongan);
                    $('#tarif_per_kejadian_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.tarif_per_kejadian));
                    $('#deskripsi_detail').text(data.deskripsi || '-');
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>