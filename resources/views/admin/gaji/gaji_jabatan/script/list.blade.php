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
                ajax: { url: "{{ route('admin.gaji.gaji_jabatan.list') }}", },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'gaji_master_id' },
                    { data: 'komponen_id' },
                    { data: 'nominal' },
                ],
            });
        };

        return { init: function () { initDatatable(); } };
    }();

    $(document).ready(function () {
        KTDatatablesServerSide.init();
    });
</script>