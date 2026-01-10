<script>
    function detail(id) {
        $.ajax({
            url: "{{ route('admin.gaji.gaji_periode.show', ':id') }}".replace(':id', id),
            type: "GET",
            success: function (response) {
                if (response.success) {
                    var data = response.data;
                    $('#periode_id_detail').text(data.periode_id);
                    $('#tahun_detail').text(data.tahun);
                    $('#tanggal_mulai_detail').text(data.tanggal_mulai.split('T')[0]);
                    $('#tanggal_selesai_detail').text(data.tanggal_selesai.split('T')[0]);

                    let badgeClass = 'badge-secondary';
                    if (data.status === 'DRAFT') badgeClass = 'badge-info';
                    else if (data.status === 'FINAL') badgeClass = 'badge-primary';
                    else if (data.status === 'CLOSED') badgeClass = 'badge-danger';

                    $('#status_detail').html('<span class="badge ' + badgeClass + '">' + data.status + '</span>');

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