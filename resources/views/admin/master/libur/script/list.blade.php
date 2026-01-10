<script defer>
    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';

        // Clear any existing DataTable state to fix column issues
        if (localStorage.getItem('DataTables_example_/admin/master/libur')) {
            localStorage.removeItem('DataTables_example_/admin/master/libur');
        }

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
                url: '{{ route('admin.master.libur.list') }}',
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
                data: 'tanggal',
                name: 'tanggal',
                render: function (data) {
                    if (data) {
                        const date = new Date(data);
                        return date.toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric'
                        });
                    }
                    return '-';
                }
            }, {
                data: 'jenis_libur',
                name: 'jenis_libur'
            }, {
                data: 'nama_libur',
                name: 'nama_libur'
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