<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_jabatan.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#gaji_master_id_detail').text(data.gaji_master_id);
                    $('#komponen_id_detail').text(data.komponen_id);
                    $('#nominal_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.nominal));
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>