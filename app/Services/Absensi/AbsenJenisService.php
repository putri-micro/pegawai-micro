<?php

namespace App\Services\Absensi;

use App\Models\Absensi\AbsenJenis;
use Illuminate\Support\Collection;

final class AbsenJenisService
{
    public function getListData(): Collection
    {
        return AbsenJenis::all();
    }

    public function create(array $data): AbsenJenis
    {
        return AbsenJenis::create($data);
    }

    public function getDetailData(string $id): ?AbsenJenis
    {
        return AbsenJenis::find($id);
    }

    public function findById(string $id): ?AbsenJenis
    {
        return AbsenJenis::find($id);
    }

    public function update(AbsenJenis $absenJenis, array $data): AbsenJenis
    {
        $absenJenis->update($data);

        return $absenJenis;
    }

    public function delete(AbsenJenis $absenJenis): void
    {
        $absenJenis->delete();
    }
}
