<?php

namespace App\Services\Ref;

use App\Models\Ref\RefBank;
use Illuminate\Support\Collection;

final class RefBankService
{
    public function getListData(): Collection
    {
        return RefBank::all();
    }

    public function getListDataOrdered(string $orderBy): Collection
    {
        return RefBank::orderBy($orderBy)->get();
    }

    public function create(array $data): RefBank
    {
        return RefBank::create($data);
    }

    public function getDetailData(string $id): ?RefBank
    {
        return RefBank::find($id);
    }

    public function findById(string $id): ?RefBank
    {
        return RefBank::find($id);
    }

    public function update(RefBank $bank, array $data): RefBank
    {
        $bank->update($data);

        return $bank;
    }

    public function delete(RefBank $bank): void
    {
        $bank->delete();
    }
}
