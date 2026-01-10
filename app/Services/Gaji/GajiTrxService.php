<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiTrx;
use Illuminate\Support\Collection;

final class GajiTrxService
{
    public function getListData(): Collection
    {
        return GajiTrx::all();
    }

    public function create(array $data): GajiTrx
    {
        return GajiTrx::create($data);
    }

    public function getDetailData(string $id): ?GajiTrx
    {
        return GajiTrx::find($id);
    }

    public function findById(string $id): ?GajiTrx
    {
        return GajiTrx::find($id);
    }

    public function update(GajiTrx $gajiTrx, array $data): GajiTrx
    {
        $gajiTrx->update($data);

        return $gajiTrx;
    }

    public function delete(GajiTrx $gajiTrx): void
    {
        $gajiTrx->delete();
    }
}
