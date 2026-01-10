<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiUmum;
use Illuminate\Support\Collection;

final class GajiUmumService
{
    public function getListData(): Collection
    {
        return GajiUmum::all();
    }

    public function create(array $data): GajiUmum
    {
        return GajiUmum::create($data);
    }

    public function getDetailData(string $id): ?GajiUmum
    {
        return GajiUmum::find($id);
    }

    public function findById(string $id): ?GajiUmum
    {
        return GajiUmum::find($id);
    }

    public function update(GajiUmum $gajiUmum, array $data): GajiUmum
    {
        $gajiUmum->update($data);

        return $gajiUmum;
    }

    public function delete(GajiUmum $gajiUmum): void
    {
        $gajiUmum->delete();
    }
}
