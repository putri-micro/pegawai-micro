<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\MasterLiburRequest;
use App\Services\Master\MasterLiburService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

final class MasterLiburController extends Controller
{
    public function __construct(
        private readonly MasterLiburService $liburService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.master.libur.index');
    }

    public function list(): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            function () {
                return $this->liburService->getListData();
            },
            [
                'action' => function ($row) {
                    $rowId = $row->id_libur;

                    return implode(' ', [
                        $this->transactionService->actionButton($rowId, 'detail'),
                        $this->transactionService->actionButton($rowId, 'edit'),
                    ]);
                },
            ]
        );
    }

    public function store(MasterLiburRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->liburService->create($request->only([
                'tanggal',
                'jenis_libur',
                'nama_libur',
                'keterangan',
            ]));
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->liburService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(MasterLiburRequest $request, string $id): JsonResponse
    {
        $data = $this->liburService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->liburService->update($data, $request->only([
                'tanggal',
                'jenis_libur',
                'nama_libur',
                'keterangan',
            ]));
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->liburService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->liburService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
