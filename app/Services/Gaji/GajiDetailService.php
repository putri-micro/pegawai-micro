<?php

namespace App\Services\Gaji;

use App\Models\Gaji\GajiDetail;
use Illuminate\Support\Collection;

final class GajiDetailService
{
    public function getListData(): Collection
    {
        return GajiDetail::all();
    }

    public function create(array $data): GajiDetail
    {
        return GajiDetail::create($data);
    }

    public function getDetailData(string $id): ?GajiDetail
    {
        return GajiDetail::find($id);
    }

    public function findById(string $id): ?GajiDetail
    {
        return GajiDetail::find($id);
    }

    public function update(GajiDetail $gajiDetail, array $data): GajiDetail
    {
        $gajiDetail->update($data);

        return $gajiDetail;
    }

    public function delete(GajiDetail $gajiDetail): void
    {
        $gajiDetail->delete();
    }
}
