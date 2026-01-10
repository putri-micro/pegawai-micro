<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.komponen_gaji.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#komponen_id_detail').text(data.komponen_id);
                    $('#nama_komponen_detail').text(data.nama_komponen);
                    $('#jenis_detail').html(data.jenis == 'PENGHASIL' ? '<span class="badge badge-light-success">PENGHASIL</span>' : '<span class="badge badge-light-danger">POTONGAN</span>');
                    $('#deskripsi_detail').text(data.deskripsi || '-');
                    $('#is_umum_detail').html(data.is_umum == 1 ? '<span class="badge badge-light-primary">YA</span>' : '<span class="badge badge-light-secondary">TIDAK</span>');
                    $('#umum_id_detail').text(data.umum_id || '-');
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>