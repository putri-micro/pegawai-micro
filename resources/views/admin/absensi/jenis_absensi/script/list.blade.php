<script>
    "use strict";
    var KTDatatablesServerSide = function () {
        var initDatatable = function () {
            var table = $('#example').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [
                    [1, 'asc']
                ],
                stateSave: true,
                select: {
                    style: 'multi',
                    selector: 'td:first-child input[type="checkbox"]',
                    className: 'row-selected'
                },
                ajax: {
                    url: "{{ route('admin.absensi.jenis_absensi.list') }}",
                },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'nama_absen' },
                    { data: 'kategori' },
                    {
                        data: 'potong_gaji', render: function (data) {
                            return data == 1 ? '<span class="badge badge-light-danger">Ya</span>' : '<span class="badge badge-light-success">Tidak</span>';
                        }
                    },
                ],
            });
        };

        return {
            init: function () {
                initDatatable();
            }
        };
    }();

    $(document).ready(function () {
        KTDatatablesServerSide.init();
    });
</script>