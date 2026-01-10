<script>
    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: "lBfrtip",
            stateSave: true,
            stateDuration: -1,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            buttons: [{
                extend: 'colvis',
                collectionLayout: 'fixed columns',
                collectionTitle: 'Column visibility control',
                className: 'btn btn-sm btn-dark rounded-2',
                columns: ':not(.noVis)'
            },
            {
                extend: "csv",
                titleAttr: 'Csv',
                action: newexportaction,
                className: 'btn btn-sm btn-dark rounded-2',
            },
            {
                extend: "excel",
                titleAttr: 'Excel',
                action: newexportaction,
                className: 'btn btn-sm btn-dark rounded-2',
            },
            ],
            processing: true,
            serverSide: true,
            responsive: true,
            searchHighlight: true,
            ajax: {
                url: '{{ route('admin.absensi.absensi.list') }}',
                cache: false,
            },
            order: [],
            ordering: true,
            columns: [{
                data: "action",
                name: "action",
                orderable: false,
                searchable: false
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'id_sdm',
                name: 'id_sdm'
            },
            {
                data: 'total_jam_kerja',
                name: 'total_jam_kerja',
                render: function (data) {
                    return data ? parseFloat(data).toFixed(2) : '-';
                }
            },
            {
                data: 'total_terlambat',
                name: 'total_terlambat',
                render: function (data) {
                    return data ? parseFloat(data).toFixed(2) : '-';
                }
            },
            {
                data: 'total_pulang_awal',
                name: 'total_pulang_awal',
                render: function (data) {
                    return data ? parseFloat(data).toFixed(2) : '-';
                }
            },
            ],
        });

        const performOptimizedSearch = _.debounce(function (query) {
            try {
                if (query.length >= 3 || query.length === 0) {
                    table.search(query).draw();
                }
            } catch (error) {
                console.error("Error during search:", error);
            }
        }, 500);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });
    }

    $(document).ready(function () {
        load_data();
    });
</script>