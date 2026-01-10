<script>
    "use strict";
    var KTDatatablesServerSide = function () {
        var initDatatable = function () {
            var table = $('#example').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                order: [
                    [2, 'desc'],
                    [1, 'desc']
                ],
                stateSave: true,
                ajax: {
                    url: "{{ route('admin.gaji.gaji_periode.list') }}",
                },
                columns: [
                    { data: 'action', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'periode_id' },
                    { data: 'tahun' },
                    { data: 'tanggal_mulai' },
                    { data: 'tanggal_selesai' },
                    { data: 'status', className: 'text-center' },
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