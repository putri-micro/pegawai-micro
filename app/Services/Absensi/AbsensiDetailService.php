<?php

namespace App\Services\Absensi;

use App\Models\Absensi\AbsensiDetail;
use App\Models\Absensi\Absensi;
use App\Models\Absensi\AbsenJenis;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

final class AbsensiDetailService
{
    public function getListData(Request $request)
    {
        return AbsensiDetail::query()
            ->with(['absensi', 'jenisAbsen']);
    }

    public function create(array $data)
    {
        return AbsensiDetail::create($data);
    }

    public function findById(string $id)
    {
        return AbsensiDetail::with(['absensi', 'jenisAbsen'])->find($id);
    }

    public function update(AbsensiDetail $absensiDetail, array $data)
    {
        $absensiDetail->update($data);
        return $absensiDetail;
    }

    public function delete(AbsensiDetail $absensiDetail)
    {
        return $absensiDetail->delete();
    }

    public function getAbsensiDropdown()
    {
        return Absensi::orderBy('tanggal', 'desc')->get();
    }

    public function getJenisAbsenDropdown()
    {
        return AbsenJenis::orderBy('nama_absen')->get();
    }
}
