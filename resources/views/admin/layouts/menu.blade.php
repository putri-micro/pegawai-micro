<div class="hover-scroll-overlay-y my-5 my-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu"
    data-kt-scroll-offset="0">
    <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
        id="#kt_aside_menu" data-kt-menu="true">
        <div class="menu-item">
            <!-- Data Utama -->
            <a class="menu-link" href="{{ route('index') }}">
                <span class="menu-title">Dashboard</span>
            </a>
            <a class="menu-link {{ request()->routeIs('admin.person.index') ? 'active' : '' }}"
                href="{{ route('admin.person.index') }}">
                <span class="menu-title">Person</span>
            </a>
            <a class="menu-link {{ request()->routeIs('admin.sdm.sdm.index') ? 'active' : '' }}"
                href="{{ route('admin.sdm.sdm.index') }}">
                <span class="menu-title">SDM</span>
            </a>
            @php
                $referensiActive = request()->routeIs('admin.ref.jenjang-pendidikan.*') ||
                    request()->routeIs('admin.ref.hubungan-keluarga.*') ||
                    request()->routeIs('admin.ref.jenis-asuransi.*') ||
                    request()->routeIs('admin.ref.eselon.*') ||
                    request()->routeIs('admin.ref.bank.*');
            @endphp
            <div data-kt-menu-trigger="click"
                class="menu-item menu-accordion {{ $referensiActive ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-title">Referensi</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <a class="menu-link {{ request()->routeIs('admin.ref.jenjang-pendidikan.*') ? 'active' : '' }}"
                        href="{{ route('admin.ref.jenjang-pendidikan.index') }}">
                        <span class="menu-title px-4">Jenjang Pendidikan</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.ref.hubungan-keluarga.*') ? 'active' : '' }}"
                        href="{{ route('admin.ref.hubungan-keluarga.index') }}">
                        <span class="menu-title px-4">Hubungan Keluarga</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.ref.jenis-asuransi.*') ? 'active' : '' }}"
                        href="{{ route('admin.ref.jenis-asuransi.index') }}">
                        <span class="menu-title px-4">Jenis Asuransi</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.ref.eselon.*') ? 'active' : '' }}"
                        href="{{ route('admin.ref.eselon.index') }}">
                        <span class="menu-title px-4">Eselon</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.ref.bank.*') ? 'active' : '' }}"
                        href="{{ route('admin.ref.bank.index') }}">
                        <span class="menu-title px-4">Bank</span>
                    </a>
                </div>
            </div>
            @php
                $masterActive = request()->routeIs('admin.master.periode.*') || request()->routeIs('admin.master.unit.*') || request()->routeIs('admin.master.jabatan.*') || request()->routeIs('admin.master.libur.*') || request()->routeIs('admin.master.jadwal-kerja.*');
            @endphp
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $masterActive ? 'here show' : '' }}">
                <span class="menu-link">
                    <span class="menu-title">Master</span>
                    <span class="menu-arrow"></span>
                </span>
                <div class="menu-sub menu-sub-accordion menu-active-bg">
                    <a class="menu-link {{ request()->routeIs('admin.master.periode.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.periode.index') }}">
                        <span class="menu-title px-4">Periode</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.master.unit.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.unit.index') }}">
                        <span class="menu-title px-4">Unit</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.master.jabatan.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.jabatan.index') }}">
                        <span class="menu-title px-4">Jabatan</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.master.libur.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.libur.index') }}">
                        <span class="menu-title px-4">Libur</span>
                    </a>
                    <a class="menu-link {{ request()->routeIs('admin.master.jadwal-kerja.*') ? 'active' : '' }}"
                        href="{{ route('admin.master.jadwal-kerja.index') }}">
                        <span class="menu-title px-4">Jadwal Kerja</span>
                    </a>
                </div>
            </div>
        </div>
        @php
            $absensiActive = request()->routeIs('admin.absensi.*');
        @endphp
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $absensiActive ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-title">Absensi</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
                <a class="menu-link {{ request()->routeIs('admin.absensi.jenis_absensi.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.jenis_absensi.index') }}">
                    <span class="menu-title px-4">Jenis Absensi</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.absensi.absensi.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.absensi.index') }}">
                    <span class="menu-title px-4">Data Absensi</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.absensi.absensi_detail.*') ? 'active' : '' }}"
                    href="{{ route('admin.absensi.absensi_detail.index') }}">
                    <span class="menu-title px-4">Detail Absensi</span>
                </a>
            </div>
        </div>
        @php
            $gajiActive = request()->routeIs('admin.gaji.gaji_periode.*') || request()->routeIs('admin.gaji.gaji_umum.*') || request()->routeIs('admin.gaji.komponen_gaji.*') || request()->routeIs('admin.gaji.tarif_lembur.*') || request()->routeIs('admin.gaji.tarif_potongan.*') || request()->routeIs('admin.gaji.gaji_jabatan.*') || request()->routeIs('admin.gaji.gaji_trx.*') || request()->routeIs('admin.gaji.gaji_detail.*');
        @endphp
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion {{ $gajiActive ? 'here show' : '' }}">
            <span class="menu-link">
                <span class="menu-title">Gaji</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
                <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_periode.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_periode.index') }}">
                    <span class="menu-title px-4">Gaji Periode</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_umum.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_umum.index') }}">
                    <span class="menu-title px-4">Gaji Umum</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.komponen_gaji.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.komponen_gaji.index') }}">
                    <span class="menu-title px-4">Komponen Gaji</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.tarif_lembur.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.tarif_lembur.index') }}">
                    <span class="menu-title px-4">Tarif Lembur</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.tarif_potongan.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.tarif_potongan.index') }}">
                    <span class="menu-title px-4">Tarif Potongan</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_jabatan.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_jabatan.index') }}">
                    <span class="menu-title px-4">Gaji Jabatan</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_trx.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_trx.index') }}">
                    <span class="menu-title px-4">Gaji Trx</span>
                </a>
                <a class="menu-link {{ request()->routeIs('admin.gaji.gaji_detail.*') ? 'active' : '' }}"
                    href="{{ route('admin.gaji.gaji_detail.index') }}">
                    <span class="menu-title px-4">Gaji Detail</span>
                </a>
            </div>
        </div>
    </div>
</div>