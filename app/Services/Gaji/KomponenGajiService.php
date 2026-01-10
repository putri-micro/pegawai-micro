<?php

namespace App\Services\Gaji;

use App\Models\Gaji\KomponenGaji;
use Illuminate\Support\Collection;

final class KomponenGajiService
{
    public function getListData(): Collection
    {
        return KomponenGaji::all();
    }

    public function create(array $data): KomponenGaji
    {
        return KomponenGaji::create($data);
    }

    public function getDetailData(string $id): ?KomponenGaji
    {
        return KomponenGaji::find($id);
    }

    public function findById(string $id): ?KomponenGaji
    {
        return KomponenGaji::find($id);
    }

    public function update(KomponenGaji $komponenGaji, array $data): KomponenGaji
    {
        $komponenGaji->update($data);

        return $komponenGaji;
    }

    public function delete(KomponenGaji $komponenGaji): void
    {
        $komponenGaji->delete();
    }
}
