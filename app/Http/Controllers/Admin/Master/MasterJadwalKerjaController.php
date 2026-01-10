<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MasterJadwalKerjaRequest;
use App\Services\Master\MasterJadwalKerjaService;
use App\Services\Master\MasterLiburService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class MasterJadwalKerjaController extends Controller
{
    public function __construct(
        private MasterJadwalKerjaService $jadwalKerjaService,
        private MasterLiburService $liburService,
        private ResponseService $responseService,
        private TransactionService $transactionService,
    ) {
    }

    public function index(): View
    {
        $libur = $this->liburService->getListData();
        return view('admin.master.jadwal_kerja.index', compact('libur'));
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->jadwalKerjaService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_jadwal_kerja;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                        $this->transactionService->actionButton($rowId, 'delete'),
                    ]);
                },
            ]
        );
    }

    public function store(MasterJadwalKerjaRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->jadwalKerjaService->create($request->validated());

            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($id) {
            $data = $this->jadwalKerjaService->getDetailData($id);

            return $this->responseService->successResponse('Detail Data', $data);
        });
    }

    public function update(MasterJadwalKerjaRequest $request, string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request, $id) {
            $jadwal = $this->jadwalKerjaService->findById($id);
            $data = $this->jadwalKerjaService->update($jadwal, $request->validated());

            return $this->responseService->successResponse('Data berhasil diubah', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($id) {
            $jadwal = $this->jadwalKerjaService->findById($id);
            $this->jadwalKerjaService->delete($jadwal);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
