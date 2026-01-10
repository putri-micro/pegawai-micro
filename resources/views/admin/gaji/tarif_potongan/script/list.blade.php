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
                ajax: { url: "{{ route('admin.gaji.tarif_potongan.list') }}", },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'potongan_id' },
                    { data: 'nama_potongan' },
                    { data: 'tarif_per_kejadian' },
                    { data: 'deskripsi' },
                ],
            });
        };

        return { init: function () { initDatatable(); } };
    }();

    $(document).ready(function () {
        KTDatatablesServerSide.init();
    });
</script>