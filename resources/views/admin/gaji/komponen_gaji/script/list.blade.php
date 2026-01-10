<script>
    "use strict";
    var KTDatatablesServerSide = function () {
        var initDatatable = function () {
            var table = $('#example').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [[1, 'asc']],
                stateSave: true,
                ajax: { url: "{{ route('admin.gaji.komponen_gaji.list') }}", },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'komponen_id' },
                    { data: 'nama_komponen' },
                    { data: 'jenis' },
                    { data: 'is_umum' },
                    { data: 'umum_id' },
                ],
            });
        };

        return { init: function () { initDatatable(); } };
    }();

    $(document).ready(function () {
        KTDatatablesServerSide.init();
    });
</script>