<?php

namespace App\Http\Controllers\Admin\Gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gaji\TarifPotonganRequest;
use App\Services\Gaji\TarifPotonganService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class TarifPotonganController extends Controller
{
    public function __construct(
        private readonly TarifPotonganService $tarifPotonganService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.gaji.tarif_potongan.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->tarifPotonganService->getListData();
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
                'tarif_per_kejadian' => function ($row) {
                    return 'Rp ' . number_format($row->tarif_per_kejadian, 2, ',', '.');
                },
            ]
        );
    }

    public function store(TarifPotonganRequest $request): JsonResponse
    {
        try {
            $data = $this->tarifPotonganService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving TarifPotongan: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->tarifPotonganService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(TarifPotonganRequest $request, string $id): JsonResponse
    {
        $data = $this->tarifPotonganService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->tarifPotonganService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->tarifPotonganService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->tarifPotonganService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
