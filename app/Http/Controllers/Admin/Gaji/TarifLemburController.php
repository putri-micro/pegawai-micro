<?php

namespace App\Http\Controllers\Admin\Gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gaji\TarifLemburRequest;
use App\Services\Gaji\TarifLemburService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class TarifLemburController extends Controller
{
    public function __construct(
        private readonly TarifLemburService $tarifLemburService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.gaji.tarif_lembur.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->tarifLemburService->getListData();
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
                'tarif_per_jam' => function ($row) {
                    return 'Rp ' . number_format($row->tarif_per_jam, 2, ',', '.');
                },
                'berlaku_mulai' => function ($row) {
                    return $row->berlaku_mulai ? $row->berlaku_mulai->format('d-m-Y') : '-';
                },
                'jenis_lembur' => function ($row) {
                    $color = $row->jenis_lembur === 'BIASA' ? 'primary' : 'warning';
                    return '<span class="badge badge-light-' . $color . '">' . $row->jenis_lembur . '</span>';
                },
            ]
        );
    }

    public function store(TarifLemburRequest $request): JsonResponse
    {
        try {
            $data = $this->tarifLemburService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving TarifLembur: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->tarifLemburService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(TarifLemburRequest $request, string $id): JsonResponse
    {
        $data = $this->tarifLemburService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->tarifLemburService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->tarifLemburService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->tarifLemburService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
