<script>
    $(document).ready(function () {
        let table = $('#example').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.sdm.jadwal-karyawan.list', $id) }}",
            columns: [{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
            {
                data: 'nama_jadwal',
                name: 'nama_jadwal'
            },
            {
                data: 'jam_kerja',
                name: 'jam_kerja'
            },
            {
                data: 'tanggal_mulai',
                name: 'tanggal_mulai'
            },
            {
                data: 'tanggal_selesai',
                name: 'tanggal_selesai'
            },
            ],
            order: [
                [3, 'desc']
            ]
        });

        // Refresh table function
        window.refreshTable = function () {
            table.draw();
        }
    });
</script>