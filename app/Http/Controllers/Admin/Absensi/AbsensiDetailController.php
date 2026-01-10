<?php

namespace App\Http\Controllers\Admin\Absensi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Absensi\AbsensiDetailRequest;
use App\Services\Absensi\AbsensiDetailService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

final class AbsensiDetailController extends Controller
{
    public function __construct(
        private readonly AbsensiDetailService $absensiDetailService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.absensi.absensi_detail.index');
    }

    public function getAbsensiDropdown(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->absensiDetailService->getAbsensiDropdown();
            return $this->responseService->successResponse('Data absensi berhasil diambil', $data);
        });
    }

    public function getJenisAbsenDropdown(): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () {
            $data = $this->absensiDetailService->getJenisAbsenDropdown();
            return $this->responseService->successResponse('Data jenis absen berhasil diambil', $data);
        });
    }

    public function list(Request $request): JsonResponse
    {
        return $this->transactionService->handleWithDataTable(
            fn() => $this->absensiDetailService->getListData($request),
            [
                'tanggal' => fn($row) => $row->absensi->tanggal ?? '-',
                'jenis_absen_name' => fn($row) => $row->jenisAbsen->nama_absen ?? '-',
                'waktu_mulai' => fn($row) => $row->waktu_mulai ? $row->waktu_mulai->format('d-m-Y H:i') : '-',
                'waktu_selesai' => fn($row) => $row->waktu_selesai ? $row->waktu_selesai->format('d-m-Y H:i') : '-',
                'durasi_jam' => fn($row) => $row->durasi_jam . ' Jam',
                'action' => fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_detail, 'detail'),
                    $this->transactionService->actionButton($row->id_detail, 'edit'),
                    $this->transactionService->actionButton($row->id_detail, 'delete'),
                ]),
            ]
        );
    }

    public function store(AbsensiDetailRequest $request): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($request) {
            $data = $this->absensiDetailService->create($request->validated());
            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->absensiDetailService->findById($id);
            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan');
            }
            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(AbsensiDetailRequest $request, string $id): JsonResponse
    {
        $data = $this->absensiDetailService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->absensiDetailService->update($data, $request->validated());
            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        $data = $this->absensiDetailService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($data) {
            $this->absensiDetailService->delete($data);
            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
