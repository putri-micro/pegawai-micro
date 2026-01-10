<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\SdmJadwalKaryawanRequest;
use App\Services\Sdm\SdmJadwalKaryawanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SdmJadwalKaryawanController extends Controller
{
    public function __construct(
        private readonly SdmJadwalKaryawanService $sdmJadwalKaryawanService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(string $uuid): View
    {
        $person = $this->sdmJadwalKaryawanService->getPersonDetailByUuid($uuid);
        $jadwalKerja = \App\Models\Master\MasterJadwalKerja::get();

        return view('admin.sdm.jadwal_karyawan.index', [
            'person' => $person,
            'id' => $uuid,
            'jadwalKerja' => $jadwalKerja
        ]);
    }

    public function list(string $uuid, Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($uuid, $request) {
                return $this->sdmJadwalKaryawanService->getListData($uuid, $request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_karyawan, 'detail'),
                    $this->transactionService->actionButton($row->id_karyawan, 'edit'),
                    $this->transactionService->actionButton($row->id_karyawan, 'delete'),
                ]),
            ]
        );
    }

    public function store(SdmJadwalKaryawanRequest $request): JsonResponse
    {
        $idSdm = $this->sdmJadwalKaryawanService->resolveIdSdmFromUuid($request->uuid_person);
        if (!$idSdm) {
            return $this->responseService->errorResponse('SDM tidak ditemukan');
        }

        try {
            return $this->transactionService->handleWithTransaction(function () use ($request, $idSdm) {
                $payload = $request->validated();
                $payload['id_sdm'] = $idSdm;
                $payload['dibuat_oleh'] = auth()->id();

                $data = $this->sdmJadwalKaryawanService->create($payload);
                return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
            });
        } catch (\Exception $e) {
            return $this->responseService->errorResponse($e->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->sdmJadwalKaryawanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(SdmJadwalKaryawanRequest $request, string $id): JsonResponse
    {
        $data = $this->sdmJadwalKaryawanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $payload = $request->validated();
            $updatedData = $this->sdmJadwalKaryawanService->update($data, $payload);
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->sdmJadwalKaryawanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->sdmJadwalKaryawanService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
