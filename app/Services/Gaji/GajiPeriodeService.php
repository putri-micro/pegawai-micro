<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiPeriode;
use Illuminate\Support\Collection;

final class GajiPeriodeService
{
    public function getListData(): Collection
    {
        return GajiPeriode::all();
    }

    public function create(array $data): GajiPeriode
    {
        return GajiPeriode::create($data);
    }

    public function getDetailData(string $id): ?GajiPeriode
    {
        return GajiPeriode::find($id);
    }

    public function findById(string $id): ?GajiPeriode
    {
        return GajiPeriode::find($id);
    }

    public function update(GajiPeriode $gajiPeriode, array $data): GajiPeriode
    {
        $gajiPeriode->update($data);

        return $gajiPeriode;
    }

    public function delete(GajiPeriode $gajiPeriode): void
    {
        $gajiPeriode->delete();
    }
}
