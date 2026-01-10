@extends('admin.layouts.index')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/responsive.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/buttons.dataTables.min.css') }}">
@endsection

@section('list')
    <li class="breadcrumb-item text-muted">Absensi</li>
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-200 w-5px h-2px"></span>
    </li>
    <li class="breadcrumb-item text-dark">Detail Absensi</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card mb-5 mb-xl-8 border-2 shadow">
            <!-- Header -->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Data Detail Absensi</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Kelola data detail absensi di sini.</span>
                </h3>
                <div class="card-toolbar">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#form_create">
                        <span class="bi bi-plus fs-3"></span> Tambah Detail Absensi
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="card-body py-3">
                <div
                    class="table-responsive mb-8 shadow p-4 mx-0 border-hover-dark border-primary border-1 border-dashed fs-sm-8 fs-lg-6 rounded-2">
                    <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="example">
                        <thead>
                            <tr class="fw-bold text-muted text-uppercase gs-0">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-150px">Tanggal Absensi</th>
                                <th class="min-w-150px">Jenis Absen</th>
                                <th class="min-w-150px">Waktu Mulai</th>
                                <th class="min-w-150px">Waktu Selesai</th>
                                <th class="min-w-100px">Durasi</th>
                                <th class="min-w-100px text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 fw-bolder">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.absensi.absensi_detail.view.create')
    @include('admin.absensi.absensi_detail.view.edit')
    @include('admin.absensi.absensi_detail.view.detail')
@endsection

@section('javascript')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/lodash.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>

    <script>
        function fetchDataDropdown(url, id, placeholder, name, callback) {
            if (typeof DataManager !== 'undefined') {
                DataManager.fetchData(url).then(response => {
                    $(id).empty().append('<option></option>');
                    if (response.success) {
                        response.data.forEach(item => {
                            $(id).append(`<option value="${item['id_' + placeholder]}">${item[name]}</option>`);
                        });
                        $(id).select2({
                            dropdownParent: $(id).closest('.modal')
                        });
                        if (callback) callback();
                    }
                }).catch(error => console.error(error));
            }
        }

        // Initialize dropdowns when modals are shown
        $('#form_create').on('shown.bs.modal', function () {
            fetchDataDropdown("{{ route('admin.absensi.absensi_detail.dropdown.absensi') }}", 'select[name="id_absensi"]', 'absensi', 'tanggal');
            fetchDataDropdown("{{ route('admin.absensi.absensi_detail.dropdown.jenis_absen') }}", 'select[name="id_jenis_absen"]', 'jenis_absen', 'nama_absen');
        });

        $('#form_edit').on('shown.bs.modal', function () {
            fetchDataDropdown("{{ route('admin.absensi.absensi_detail.dropdown.absensi') }}", '#edit_id_absensi', 'absensi', 'tanggal');
            fetchDataDropdown("{{ route('admin.absensi.absensi_detail.dropdown.jenis_absen') }}", '#edit_id_jenis_absen', 'jenis_absen', 'nama_absen');
        });
    </script>

    @include('admin.absensi.absensi_detail.script.list')
    @include('admin.absensi.absensi_detail.script.create')
    @include('admin.absensi.absensi_detail.script.edit')
@endsection