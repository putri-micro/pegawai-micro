<?php

namespace App\Services\Sdm;

use App\Models\Sdm\SdmJadwalKaryawan;
use App\Models\Sdm\PersonSdm;
use App\Services\Master\MasterJadwalKerjaService;
use App\Services\Sdm\PersonSdmService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SdmJadwalKaryawanService
{
    public function __construct(
        private readonly PersonSdmService $personSdmService,
        private readonly MasterJadwalKerjaService $masterJadwalKerjaService
    ) {
    }

    public function getPersonDetailByUuid(string $uuid)
    {
        return $this->personSdmService->getPersonDetailByUuid($uuid);
    }

    public function resolveIdSdmFromUuid(string $uuid): ?int
    {
        return PersonSdm::query()
            ->join('person', 'person.id', '=', 'person_sdm.id')
            ->where('person.uuid_person', $uuid)
            ->value('person_sdm.id_sdm');
    }

    public function getListData(string $uuid, Request $request)
    {
        $idSdm = $this->resolveIdSdmFromUuid($uuid);

        if (!$idSdm) {
            return SdmJadwalKaryawan::query()->whereNull('id_karyawan');
        }

        return SdmJadwalKaryawan::query()
            ->join('master_jadwal_kerja', 'master_jadwal_kerja.id_jadwal_kerja', '=', 'sdm_jadwal_karyawan.id_jadwal_kerja')
            ->select([
                'sdm_jadwal_karyawan.*',
                'master_jadwal_kerja.nama_jadwal',
                DB::raw("CONCAT(master_jadwal_kerja.jam_masuk, ' - ', master_jadwal_kerja.jam_pulang) as jam_kerja")
            ])
            ->where('sdm_jadwal_karyawan.id_sdm', $idSdm)
            ->orderBy('sdm_jadwal_karyawan.tanggal_mulai', 'DESC');
    }

    public function create(array $data): SdmJadwalKaryawan
    {
        return SdmJadwalKaryawan::create($data);
    }

    public function findById(string $id): ?SdmJadwalKaryawan
    {
        return SdmJadwalKaryawan::find($id);
    }

    public function update(SdmJadwalKaryawan $data, array $payload): SdmJadwalKaryawan
    {
        $data->update($payload);
        return $data;
    }

    public function delete(SdmJadwalKaryawan $data): void
    {
        $data->delete();
    }

    public function getDetailData(string $id): ?SdmJadwalKaryawan
    {
        return SdmJadwalKaryawan::with(['jadwalKerja'])->find($id);
    }
}
