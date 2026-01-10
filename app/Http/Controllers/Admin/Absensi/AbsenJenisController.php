<?php

namespace App\Http\Controllers\Admin\Absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Absensi\AbsenJenisRequest;
use App\Services\Absensi\AbsenJenisService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class AbsenJenisController extends Controller
{
    public function __construct(
        private readonly AbsenJenisService $absenJenisService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.absensi.jenis_absensi.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->absenJenisService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_jenis_absen;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                        $this->transactionService->actionButton($rowId, 'delete'),
                    ]);
                },
            ]
        );
    }

    public function store(AbsenJenisRequest $request): JsonResponse
    {
        try {
            $data = $this->absenJenisService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        } catch (\Throwable $th) {
            \Illuminate\Support\Facades\Log::error('Error saving AbsenJenis: ' . $th->getMessage());
            return $this->responseService->errorResponse($th->getMessage());
        }
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->absenJenisService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(AbsenJenisRequest $request, string $id): JsonResponse
    {
        $data = $this->absenJenisService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }
        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->absenJenisService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->absenJenisService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->absenJenisService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
