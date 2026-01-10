<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.absensi.jenis_absensi.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#nama_absen_detail').text(data.nama_absen);
                    $('#kategori_detail').text(data.kategori);

                    if (data.potong_gaji == 1) {
                        $('#potong_gaji_detail').html('<span class="badge badge-light-danger">Ya</span>');
                    } else {
                        $('#potong_gaji_detail').html('<span class="badge badge-light-success">Tidak</span>');
                    }

                    $('#modal_detail').modal('show');
                }
            },
            error: function (xhr) {
                Swal.fire({
                    text: "Gagal mengambil data",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, mengerti!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            }
        });
    }
</script>