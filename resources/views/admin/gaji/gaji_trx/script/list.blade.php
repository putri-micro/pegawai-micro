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
                ajax: { url: "{{ route('admin.gaji.gaji_trx.list') }}", },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'transaksi_id' },
                    { data: 'periode_id' },
                    { data: 'total_penghasil' },
                    { data: 'total_potongan' },
                    { data: 'total_dibayar' },
                ],
            });
        };

        return { init: function () { initDatatable(); } };
    }();

    $(document).ready(function () {
        KTDatatablesServerSide.init();
    });
</script>