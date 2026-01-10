<?php

namespace App\Services\Absensi;

use App\Models\Absensi\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AbsensiService
{
    public function getListData(Request $request)
    {
        $query = Absensi::query();

        if ($request->filled('search.value')) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('id_absensi', 'like', "%{$search}%")
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('id_sdm', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    public function create(array $data)
    {
        return Absensi::create($data);
    }

    public function update(Absensi $absensi, array $data)
    {
        $absensi->update($data);
        return $absensi;
    }

    public function delete(Absensi $absensi)
    {
        return $absensi->delete();
    }

    public function findById($id)
    {
        return Absensi::find($id);
    }

    public function getDetailData($id)
    {
        return Absensi::findOrFail($id);
    }

    public function getJadwalDropdownData(Request $request)
    {
        return \App\Models\Sdm\SdmJadwalKaryawan::query()
            ->join('master_jadwal_kerja', 'master_jadwal_kerja.id_jadwal_kerja', '=', 'sdm_jadwal_karyawan.id_jadwal_kerja')
            ->join('person_sdm', 'person_sdm.id_sdm', '=', 'sdm_jadwal_karyawan.id_sdm')
            ->join('person', 'person.id', '=', 'person_sdm.id')
            ->select([
                'sdm_jadwal_karyawan.id_karyawan',
                'sdm_jadwal_karyawan.id_sdm',
                'sdm_jadwal_karyawan.tanggal_mulai',
                'sdm_jadwal_karyawan.tanggal_selesai',
                'master_jadwal_kerja.nama_jadwal',
                'person.nama_lengkap'
            ])
            ->get()
            ->map(function ($item) {
                return [
                    'id_jadwal_karyawan' => $item->id_karyawan,
                    'id_sdm' => $item->id_sdm,
                    'nama_jadwal_lengkap' => "{$item->nama_lengkap} - {$item->nama_jadwal} ({$item->tanggal_mulai} sd {$item->tanggal_selesai})",
                ];
            });
    }
}
