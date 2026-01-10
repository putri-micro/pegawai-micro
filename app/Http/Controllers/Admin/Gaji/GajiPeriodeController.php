<?php

namespace App\Http\Controllers\Admin\Gaji;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gaji\GajiPeriodeRequest;
use App\Services\Gaji\GajiPeriodeService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class GajiPeriodeController extends Controller
{
    public function __construct(
        private readonly GajiPeriodeService $gajiPeriodeService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.gaji.gaji_periode.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->gajiPeriodeService->getListData();
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
                'status' => function ($row) {
                    $badgeClass = match ($row->status) {
                        'DRAFT' => 'badge-info',
                        'FINAL' => 'badge-primary',
                        'CLOSED' => 'badge-danger',
                        default => 'badge-secondary',
                    };
                    return '<span class="badge ' . $badgeClass . '">' . $row->status . '</span>';
                },
                'tanggal_mulai' => function ($row) {
                    return $row->tanggal_mulai->format('d-m-Y');
                },
                'tanggal_selesai' => function ($row) {
                    return $row->tanggal_selesai->format('d-m-Y');
                },
            ]
        );
    }

    public function store(GajiPeriodeRequest $request): JsonResponse
    {
        try {
            $data = $this->gajiPeriodeService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving GajiPeriode: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->gajiPeriodeService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(GajiPeriodeRequest $request, string $id): JsonResponse
    {
        $data = $this->gajiPeriodeService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->gajiPeriodeService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->gajiPeriodeService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->gajiPeriodeService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
