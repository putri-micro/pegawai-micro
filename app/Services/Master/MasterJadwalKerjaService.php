<?php

namespace App\Services\Master;

use App\Models\Master\MasterJadwalKerja;
use Illuminate\Support\Collection;

final class MasterJadwalKerjaService
{
    public function getListData(): Collection
    {
        return MasterJadwalKerja::with('libur')->orderByDesc('created_at')->get();
    }

    public function create(array $data): MasterJadwalKerja
    {
        return MasterJadwalKerja::create($data);
    }

    public function getDetailData(string $id): ?MasterJadwalKerja
    {
        return MasterJadwalKerja::with('libur')->find($id);
    }

    public function findById(string $id): ?MasterJadwalKerja
    {
        return MasterJadwalKerja::find($id);
    }

    public function update(MasterJadwalKerja $jadwal, array $data): MasterJadwalKerja
    {
        $jadwal->update($data);

        return $jadwal;
    }

    public function delete(MasterJadwalKerja $jadwal): void
    {
        $jadwal->delete();
    }
}
