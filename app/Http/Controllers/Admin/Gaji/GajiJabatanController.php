<?php

namespace App\Http\Controllers\Admin\Gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gaji\GajiJabatanRequest;
use App\Services\Gaji\GajiJabatanService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class GajiJabatanController extends Controller
{
    public function __construct(
        private readonly GajiJabatanService $gajiJabatanService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.gaji.gaji_jabatan.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->gajiJabatanService->getListData();
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
                'nominal' => function ($row) {
                    return 'Rp ' . number_format($row->nominal, 2, ',', '.');
                },
            ]
        );
    }

    public function store(GajiJabatanRequest $request): JsonResponse
    {
        try {
            $data = $this->gajiJabatanService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving GajiJabatan: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->gajiJabatanService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(GajiJabatanRequest $request, string $id): JsonResponse
    {
        $data = $this->gajiJabatanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->gajiJabatanService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->gajiJabatanService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->gajiJabatanService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
