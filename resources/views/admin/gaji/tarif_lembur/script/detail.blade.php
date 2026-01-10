<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.tarif_lembur.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#tarif_id_detail').text(data.tarif_id);
                    $('#jenis_lembur_detail').html(data.jenis_lembur == 'BIASA' ? '<span class="badge badge-light-primary">BIASA</span>' : '<span class="badge badge-light-warning">LIBUR</span>');
                    $('#tarif_per_jam_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.tarif_per_jam));
                    $('#berlaku_mulai_detail').text(data.berlaku_mulai ? new Date(data.berlaku_mulai).toLocaleDateString('id-ID') : '-');
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>