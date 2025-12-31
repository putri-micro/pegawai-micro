<script defer>
    function load_data() {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#example').DataTable({
            dom: "lBfrtip",
            stateSave: false,
            stateDuration: -1,
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
                url: '{{ route('admin.sdm.sdm.list') }}',
                cache: false,
                data: function (d) {
                    d.id_jenis_sdm = $('#list_id_jenis_sdm').val();
                    d.id_status_sdm = $('#list_id_status_sdm').val();
                }
            },
            order: [],
            ordering: true,
            columns: [
                {
                    data: "action",
                    name: "action",
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        const detailBtn = `<button type="button" data-id="${row.id_sdm}" title="Detail" data-bs-toggle="modal" data-bs-target="#form_detail" class="btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1">
                            <span class="bi bi-file-text" aria-hidden="true"></span>
                        </button>`;

                        const editBtn = `<button type="button" data-id="${row.id_sdm}" title="Edit" data-bs-toggle="modal" data-bs-target="#form_edit" class="btn btn-icon btn-bg-light btn-active-text-primary btn-sm m-1">
                            <span class="bi bi-pencil" aria-hidden="true"></span>
                        </button>`;

                        let historiBtn = '';
                        if (row.uuid_person) {
                            historiBtn = `<a href="/admin/sdm/histori/${row.uuid_person}" title="Riwayat" class="btn btn-icon btn-bg-light btn-active-text-primary btn-sm me-1">
                                <span class="bi bi-folder-plus" aria-hidden="true"></span>
                            </a>`;
                        }

                        return `${detailBtn} ${editBtn} ${historiBtn}`;
                    }
                },
                {
                    data: 'nama_lengkap',
                    name: 'nama_lengkap'
                },
                {
                    data: 'nomor_sk',
                    name: 'nomor_sk'
                },
                {
                    data: 'nomor_karpeg',
                    name: 'nomor_karpeg'
                },
                {
                    data: "tmt",
                    name: "tmt",
                    render: function (data) {
                        return data == null ? "" : formatter.formatDate(data);
                    }
                },
                {
                    data: "tmt_pensiun",
                    name: "tmt_pensiun",
                    render: function (data) {
                        return data == null ? "" : formatter.formatDate(data);
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
        }, 1000);

        $('#example_filter input').unbind().on('input', function () {
            performOptimizedSearch($(this).val());
        });
    }

    load_data();
</script>