<?php

namespace App\Services\Gaji;

use App\Models\Gaji\TarifPotongan;
use Illuminate\Support\Collection;

final class TarifPotonganService
{
    public function getListData(): Collection
    {
        return TarifPotongan::all();
    }

    public function create(array $data): TarifPotongan
    {
        return TarifPotongan::create($data);
    }

    public function getDetailData(string $id): ?TarifPotongan
    {
        return TarifPotongan::find($id);
    }

    public function findById(string $id): ?TarifPotongan
    {
        return TarifPotongan::find($id);
    }

    public function update(TarifPotongan $tarifPotongan, array $data): TarifPotongan
    {
        $tarifPotongan->update($data);

        return $tarifPotongan;
    }

    public function delete(TarifPotongan $tarifPotongan): void
    {
        $tarifPotongan->delete();
    }
}
