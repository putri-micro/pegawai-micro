<?php

namespace App\Http\Requests\Absensi;

use Illuminate\Foundation\Http\FormRequest;

final class AbsensiStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'total_jam_kerja' => $this->filled('total_jam_kerja') ? str_replace(',', '.', $this->total_jam_kerja) : null,
            'total_terlambat' => $this->filled('total_terlambat') ? str_replace(',', '.', $this->total_terlambat) : null,
            'total_pulang_awal' => $this->filled('total_pulang_awal') ? str_replace(',', '.', $this->total_pulang_awal) : null,
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['nullable', 'integer'], // For update check if needed, though usually params are used
            'tanggal' => ['required', 'date'],
            'id_jadwal_karyawan' => ['required', 'integer'],
            'id_sdm' => ['required', 'integer'],
            'total_jam_kerja' => ['nullable', 'numeric'],
            'total_terlambat' => ['nullable', 'numeric'],
            'total_pulang_awal' => ['nullable', 'numeric'],
        ];
    }
}
