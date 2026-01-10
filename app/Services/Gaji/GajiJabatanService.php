<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiJabatan;
use Illuminate\Support\Collection;

final class GajiJabatanService
{
    public function getListData(): Collection
    {
        return GajiJabatan::all();
    }

    public function create(array $data): GajiJabatan
    {
        return GajiJabatan::create($data);
    }

    public function getDetailData(string $id): ?GajiJabatan
    {
        return GajiJabatan::find($id);
    }

    public function findById(string $id): ?GajiJabatan
    {
        return GajiJabatan::find($id);
    }

    public function update(GajiJabatan $gajiJabatan, array $data): GajiJabatan
    {
        $gajiJabatan->update($data);

        return $gajiJabatan;
    }

    public function delete(GajiJabatan $gajiJabatan): void
    {
        $gajiJabatan->delete();
    }
}
