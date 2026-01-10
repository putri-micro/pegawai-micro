<?php

namespace App\Http\Controllers\Admin\Gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gaji\KomponenGajiRequest;
use App\Services\Gaji\KomponenGajiService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class KomponenGajiController extends Controller
{
    public function __construct(
        private readonly KomponenGajiService $komponenGajiService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.gaji.komponen_gaji.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->komponenGajiService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                        $this->transactionService->actionButton($rowId, 'delete'),
                    ]);
                },
                'jenis' => function ($row) {
                    $color = $row->jenis === 'PENGHASIL' ? 'success' : 'danger';
                    return '<span class="badge badge-light-' . $color . '">' . $row->jenis . '</span>';
                },
                'is_umum' => function ($row) {
                    return $row->is_umum ? '<span class="badge badge-light-primary">YA</span>' : '<span class="badge badge-light-secondary">TIDAK</span>';
                },
            ]
        );
    }

    public function store(KomponenGajiRequest $request): JsonResponse
    {
        try {
            $data = $this->komponenGajiService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving KomponenGaji: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->komponenGajiService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(KomponenGajiRequest $request, string $id): JsonResponse
    {
        $data = $this->komponenGajiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->komponenGajiService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->komponenGajiService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->komponenGajiService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
