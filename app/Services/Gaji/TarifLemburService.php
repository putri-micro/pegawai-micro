<?php

namespace App\Services\Gaji;

use App\Models\Gaji\TarifLembur;
use Illuminate\Support\Collection;

final class TarifLemburService
{
    public function getListData(): Collection
    {
        return TarifLembur::all();
    }

    public function create(array $data): TarifLembur
    {
        return TarifLembur::create($data);
    }

    public function getDetailData(string $id): ?TarifLembur
    {
        return TarifLembur::find($id);
    }

    public function findById(string $id): ?TarifLembur
    {
        return TarifLembur::find($id);
    }

    public function update(TarifLembur $tarifLembur, array $data): TarifLembur
    {
        $tarifLembur->update($data);

        return $tarifLembur;
    }

    public function delete(TarifLembur $tarifLembur): void
    {
        $tarifLembur->delete();
    }
}
