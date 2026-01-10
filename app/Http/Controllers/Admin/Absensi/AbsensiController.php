<?php

namespace App\Http\Controllers\Admin\Absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Absensi\AbsensiStoreRequest;
use App\Services\Absensi\AbsensiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AbsensiController extends Controller
{
    public function __construct(
        private readonly AbsensiService $absensiService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.absensi.absensi.index');
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () use ($request) {
                return $this->absensiService->getListData($request);
            },
            [
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_absensi, 'detail'),
                    $this->transactionService->actionButton($row->id_absensi, 'edit'),
                    $this->transactionService->actionButton($row->id_absensi, 'delete'),
                ]),
            ]
        );
    }

    public function store(AbsensiStoreRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->absensiService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->absensiService->getDetailData($id);
            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(AbsensiStoreRequest $request, string $id): JsonResponse
    {
        $data = $this->absensiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->absensiService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->absensiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->absensiService->delete($data);
            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }

    public function getJadwalDropdown(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($request) {
            $data = $this->absensiService->getJadwalDropdownData($request);
            return $this->responseService->successResponse('Data jadwal berhasil diambil', $data);
        });
    }
}
