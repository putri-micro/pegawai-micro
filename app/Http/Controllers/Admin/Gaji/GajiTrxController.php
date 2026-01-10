<?php

namespace App\Http\Controllers\Admin\Gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gaji\GajiTrxRequest;
use App\Services\Gaji\GajiTrxService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class GajiTrxController extends Controller
{
    public function __construct(
        private readonly GajiTrxService $gajiTrxService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.gaji.gaji_trx.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->gajiTrxService->getListData();
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
                'total_penghasil' => function ($row) {
                    return 'Rp ' . number_format($row->total_penghasil, 2, ',', '.');
                },
                'total_potongan' => function ($row) {
                    return 'Rp ' . number_format($row->total_potongan, 2, ',', '.');
                },
                'total_dibayar' => function ($row) {
                    return 'Rp ' . number_format($row->total_dibayar, 2, ',', '.');
                },
            ]
        );
    }

    public function store(GajiTrxRequest $request): JsonResponse
    {
        try {
            $data = $this->gajiTrxService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving GajiTrx: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->gajiTrxService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(GajiTrxRequest $request, string $id): JsonResponse
    {
        $data = $this->gajiTrxService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->gajiTrxService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->gajiTrxService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->gajiTrxService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
