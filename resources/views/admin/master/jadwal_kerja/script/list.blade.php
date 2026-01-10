<script defer>
    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: 'lBfrtip',
            stateSave: false,
            pageLength: 10,
            lengthMenu: [
                [10, 15, 20, 25],
                [10, 15, 20, 25]
            ],
            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Column visibility control',
                className: 'btn btn-sm btn-dark rounded-2',
                columns: ':not(.noVis)'
            }, {
                extend: 'csv',
                titleAttr: 'Csv',
                action: newexportaction,
                className: 'btn btn-sm btn-dark rounded-2'
            }, {
                extend: 'excel',
                titleAttr: 'Excel',
                action: newexportaction,
                className: 'btn btn-sm btn-dark rounded-2'
            }],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.master.jadwal-kerja.list') }}',
                cache: false
            },
            order: [],
            ordering: true,
            columns: [{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }, {
                data: 'nama_jadwal',
                name: 'nama_jadwal'
            }, {
                data: 'jam_masuk',
                name: 'jam_masuk',
                render: function (data) {
                    return data ? data.substring(0, 5) : '-';
                }
            }, {
                data: 'jam_pulang',
                name: 'jam_pulang',
                render: function (data) {
                    return data ? data.substring(0, 5) : '-';
                }
            }, {
                data: 'istirahat_mulai',
                name: 'istirahat_mulai',
                render: function (data, type, row) {
                    if (row.istirahat_mulai && row.istirahat_selesai) {
                        return row.istirahat_mulai.substring(0, 5) + ' - ' + row.istirahat_selesai.substring(0, 5);
                    }
                    return '-';
                }
            }, {
                data: 'toleransi_menit',
                name: 'toleransi_menit',
                render: function (data) {
                    return data + ' Menit';
                }
            }, {
                data: 'libur.nama_libur',
                name: 'libur.nama_libur',
                render: function (data, type, row) {
                    return row.libur ? row.libur.nama_libur : '-';
                }
            }, {
                data: 'keterangan',
                name: 'keterangan',
                render: function (data) {
                    return data ? data : '-';
                }
            }]
        });
        const performOptimizedSearch = _.debounce(function (query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error('Error during search:', error);
            }
        }, 1000);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });
    }

    load_data();
</script>