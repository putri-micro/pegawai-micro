<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_umum.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#umum_id_detail').text(data.umum_id);
                    $('#nominal_detail').text('Rp ' + new Intl.NumberFormat('id-ID').format(data.nominal));
                    $('#modal_detail').modal('show');
                }
            }
        });
    }
</script>