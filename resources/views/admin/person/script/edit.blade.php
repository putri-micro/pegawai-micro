<script defer>
$('#form_edit').on('show.bs.modal', function (e) {
    const button = $(e.relatedTarget);
    const id = button.data("id");

    // 🔹 URL show
    const detail = '{{ route('admin.person.show', ':id') }}'.replace(':id', id);

    console.log('🔗 Fetching detail:', detail);

    // Fetch data detail
    DataManager.fetchData(detail)
        .then(function (response) {
            console.log('🟢 Response detail:', response);

            if (response.success && response.data) {
                const data = response.data;

                // Init date picker
                const edit_tanggal_lahir = $('#edit_tanggal_lahir').flatpickr({
                    dateFormat: 'Y-m-d',
                    altFormat: 'd/m/Y',
                    allowInput: false,
                    altInput: true,
                });

                $('#edit_nama_lengkap').val(data.nama_lengkap);
                $('#edit_nama_panggilan').val(data.nama_panggilan);
                $('#edit_jk').val(data.jk).trigger('change');
                $('#edit_tempat_lahir').val(data.tempat_lahir);
                edit_tanggal_lahir.setDate(data.tanggal_lahir);
                $('#edit_agama').val(data.agama);
                $('#edit_nik').val(data.nik);
                $('#edit_kk').val(data.kk);
                $('#edit_alamat').val(data.alamat);
                $('#edit_rt').val(data.rt);
                $('#edit_rw').val(data.rw);
                $('#edit_npwp').val(data.npwp);
                $('#edit_no_hp').val(data.no_hp);
                $('#edit_email').val(data.email);
                $('#edit_kewarganegaraan').val(data.kewarganegaraan);
                $('#edit_golongan_darah').val(data.golongan_darah).trigger('change');

                // 🔹 Foto preview
                if (data.foto) {
                    const photoUrl = '{{ route('admin.view-file', [':folder', ':filename']) }}'
                        .replace(':folder', 'person')
                        .replace(':filename', data.foto);
                    $('#edit_image_preview').css({
                        'background-image': `url('${photoUrl}')`,
                        'background-size': 'cover',
                        'background-position': 'center'
                    });
                } else {
                    $('#edit_image_preview').css('background-image', '');
                }

                // 🔹 Fetch alamat dropdown berantai
                fetchDataDropdown('{{ route('api.almt.provinsi') }}', '#edit_id_provinsi', 'provinsi', 'provinsi', () => {
                    $('#edit_id_provinsi').val(data.id_provinsi).trigger('change');

                    fetchDataDropdown('{{ route('api.almt.kabupaten', ':id') }}'.replace(':id', data.id_provinsi), '#edit_id_kabupaten', 'kabupaten', 'kabupaten', () => {
                        $('#edit_id_kabupaten').val(data.id_kabupaten).trigger('change');

                        fetchDataDropdown('{{ route('api.almt.kecamatan', ':id') }}'.replace(':id', data.id_kabupaten), '#edit_id_kecamatan', 'kecamatan', 'kecamatan', () => {
                            $('#edit_id_kecamatan').val(data.id_kecamatan).trigger('change');

                            fetchDataDropdown('{{ route('api.almt.desa', ':id') }}'.replace(':id', data.id_kecamatan), '#edit_id_desa', 'desa', 'desa', () => {
                                $('#edit_id_desa').val(data.id_desa).trigger('change');
                            });
                        });
                    });
                });
            } else {
                Swal.fire('Warning', response.message, 'warning');
            }
        })
        .catch(function (error) {
            ErrorHandler.handleError(error);
        });
});
</script>
