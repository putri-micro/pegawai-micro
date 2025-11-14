<?php

namespace App\Services\Sdm;

use App\Models\Person\Person;
use App\Models\Sdm\PersonSdm;
use App\Services\Person\PersonService;
use Illuminate\Support\Collection;

final readonly class PersonSdmService
{
    public function __construct(
        private PersonService $personService,
    ) {}

    /**
     * Ambil detail Person (biodata) berdasarkan UUID
     */
    public function getPersonDetailByUuid(string $uuid): ?Person
    {
        return $this->personService->getPersonDetailByUuid($uuid);
    }

    /**
     * Ambil histori SDM berdasarkan UUID PERSON
     */
    public function getHistoriByUuid(string $uuid): Collection
    {
        return PersonSdm::query()
            ->leftJoin('person', 'person.id', '=', 'person_sdm.id')   // FIX
            ->select([
                'person_sdm.id_sdm',
                'person_sdm.nomor_karpeg',
                'person_sdm.nomor_sk',
                'person_sdm.tmt',
                'person_sdm.tmt_pensiun',
                'person.nama_lengkap',
                'person.uuid_person',
            ])
            ->where('person.uuid_person', $uuid)
            ->orderByDesc('person_sdm.tmt')
            ->get();
    }

    /**
     * Ambil seluruh data list SDM
     */
    public function getListData(): Collection
    {
        return PersonSdm::query()
            ->leftJoin('person', 'person.id', '=', 'person_sdm.id')   // FIX
            ->select([
                'person_sdm.id_sdm',
                'person_sdm.nomor_karpeg',
                'person_sdm.nomor_sk',
                'person_sdm.tmt',
                'person_sdm.tmt_pensiun',
                'person.nama_lengkap',
                'person.uuid_person',
            ])
            ->get();
    }

    /**
     * Simpan data baru SDM
     */
    public function create(array $data): PersonSdm
    {
        return PersonSdm::create($data);
    }

    /**
     * Ambil detail SDM (master + biodata person)
     */
    public function getDetailData(string $id): ?PersonSdm
    {
        return PersonSdm::query()
            ->leftJoin('person', 'person.id', '=', 'person_sdm.id')  // FIX
            ->select([
                'person_sdm.*',
                'person.nik',
                'person.kk',
                'person.no_hp',
                'person.nama_lengkap',
            ])
            ->where('person_sdm.id_sdm', $id)
            ->first();
    }

    /**
     * Ambil berdasarkan primary key SDM
     */
    public function findById(string $id): ?PersonSdm
    {
        return PersonSdm::find($id);
    }

    /**
     * Update data SDM
     */
    public function update(PersonSdm $personSdm, array $data): PersonSdm
    {
        $personSdm->update($data);
        return $personSdm;
    }

    /**
     * Cek duplikasi berdasarkan id (FIX)
     */
    public function checkDuplicate(int $id): bool
    {
        return PersonSdm::where('id', $id)->exists();   // FIX
    }

    /**
     * Cari Person berdasarkan NIK
     */
    public function findByNik(string $nik): ?Person
    {
        return $this->personService->findByNik($nik);
    }

    /**
     * Cek duplikasi nomor Kartu Pegawai
     */
    public function existsByKarpeg(string $nomorKarpeg): bool
    {
        return PersonSdm::where('nomor_karpeg', $nomorKarpeg)->exists();
    }

    public function getQueryWithPerson()
    {
    return PersonSdm::with('person') // pastikan relasi 'person' ada di model
        ->select(['id_sdm', 'uuid_person', 'nomor_sk', 'nomor_karpeg', 'tmt', 'tmt_pensiun']);
    }

    

}
