<?php

namespace App\Services\Master;

use App\Models\Master\MasterLibur;
use Illuminate\Support\Collection;

final class MasterLiburService
{
    public function getListData(): Collection
    {
        return MasterLibur::all();
    }

    public function create(array $data): MasterLibur
    {
        return MasterLibur::create($data);
    }

    public function getDetailData(string $id): ?MasterLibur
    {
        return MasterLibur::find($id);
    }

    public function findById(string $id): ?MasterLibur
    {
        return MasterLibur::find($id);
    }

    public function update(MasterLibur $libur, array $data): MasterLibur
    {
        $libur->update($data);

        return $libur;
    }

    public function delete(MasterLibur $libur): void
    {
        $libur->delete();
    }
}
