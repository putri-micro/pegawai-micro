<?php

namespace App\Http\Controllers\Admin\Sdm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sdm\PersonSdmStoreRequest;
use App\Http\Requests\Sdm\PersonSdmUpdateRequest;
use App\Services\Sdm\PersonSdmService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

final class PersonSdmController extends Controller
{
    public function __construct(
        private readonly PersonSdmService $personSdmService,
        private readonly TransactionService $transactionService,
        private readonly ResponseService $responseService,
    ) {
    }

    public function index(): View
    {
        return view('admin.sdm.sdm.index');
    }

    public function histori(string $uuid): View
    {
        $person = $this->personSdmService->getPersonDetailByUuid($uuid);
        $data = $this->personSdmService->getHistoriByUuid($uuid);

        return view('admin.sdm.sdm.histori', [
            'person' => $person,
            'data' => $data,
            'id' => $uuid,
        ]);
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $query = $this->personSdmService->getListData();

            return DataTables::of($query)
                ->addColumn('action', fn($row) => implode(' ', [
                    $this->transactionService->actionButton($row->id_sdm, 'detail'),
                    $this->transactionService->actionButton($row->id_sdm, 'edit'),
                    $this->transactionService->actionLink(route('admin.sdm.sdm.histori', $row->uuid_person), 'histori', 'Riwayat'),
                    $this->transactionService->actionButton($row->id_sdm, 'delete'),
                ]))
                ->filterColumn('nama_lengkap', function ($query, $keyword) {
                    $query->where('person.nama_lengkap', 'like', "%{$keyword}%");
                })
                ->filterColumn('nomor_sk', function ($query, $keyword) {
                    $query->where('person_sdm.nomor_sk', 'like', "%{$keyword}%");
                })
                ->filterColumn('nomor_karpeg', function ($query, $keyword) {
                    $query->where('person_sdm.nomor_karpeg', 'like', "%{$keyword}%");
                })
                ->filter(function ($query) {
                    if (request()->has('search') && !empty(request()->search['value'])) {
                        $search = request()->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('person.nama_lengkap', 'like', "%{$search}%")
                                ->orWhere('person_sdm.nomor_sk', 'like', "%{$search}%")
                                ->orWhere('person_sdm.nomor_karpeg', 'like', "%{$search}%");
                        });
                    }
                }, true)
                ->rawColumns(['action'])
                ->toJson();
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage(), ['exception' => $exception]);

            return response()->json([
                'draw' => 0,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Terjadi kesalahan yang tidak terduga.'
            ], 500);
        }
    }

    public function store(PersonSdmStoreRequest $request): JsonResponse
    {
        // Jika ingin cek duplikat berdasarkan nomor_karpeg (jika diberikan)
        if ($request->filled('nomor_karpeg')) {
            if ($this->personSdmService->existsByKarpeg($request->get('nomor_karpeg'))) {
                return $this->responseService->errorResponse('Nomor karpeg sudah terdaftar untuk person lain');
            }
        }

        return $this->transactionService->handleWithTransaction(function () use ($request) {
            // Simpan hanya field yang valid untuk model sekarang
            $payload = $request->only([
                'id',
                'nomor_karpeg',
                'nomor_sk',
                'tmt',
                'tmt_pensiun',
            ]);

            $data = $this->personSdmService->create($payload);

            return $this->responseService->successResponse('Data berhasil dibuat', $data, 201);
        });
    }

    public function show(string $id): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($id) {
            $data = $this->personSdmService->getDetailData($id);

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function update(PersonSdmUpdateRequest $request, string $id): JsonResponse
    {
        $data = $this->personSdmService->findById($id);
        if (!$data) {
            return $this->responseService->errorResponse('Data tidak ditemukan');
        }

        return $this->transactionService->handleWithTransaction(function () use ($request, $data) {
            $updatedData = $this->personSdmService->update($data, $request->only([
                'nomor_karpeg',
                'nomor_sk',
                'tmt',
                'tmt_pensiun',
            ]));

            return $this->responseService->successResponse('Data berhasil diperbarui', $updatedData);
        });
    }

    public function find_by_nik($nik): JsonResponse
    {
        return $this->transactionService->handleWithShow(function () use ($nik) {
            $data = $this->personSdmService->findByNik($nik);
            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan');
            }

            return $this->responseService->successResponse('Data berhasil diambil', $data);
        });
    }

    public function destroy(string $id): JsonResponse
    {
        return $this->transactionService->handleWithTransaction(function () use ($id) {
            $data = $this->personSdmService->findById($id);
            if (!$data) {
                return $this->responseService->errorResponse('Data tidak ditemukan');
            }
            $this->personSdmService->delete($data);

            return $this->responseService->successResponse('Data berhasil dihapus');
        });
    }
}
