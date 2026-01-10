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
                ajax: { url: "{{ route('admin.gaji.gaji_detail.list') }}", },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'detail_id' },
                    { data: 'komponen_id' },
                    { data: 'nominal' },
                    { data: 'keterangan' },
                    { data: 'transaksi_id' },
                ],
            });
        };

        return { init: function () { initDatatable(); } };
    }();

    $(document).ready(function () {
        KTDatatablesServerSide.init();
    });
</script>