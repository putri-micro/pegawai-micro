<?php

namespace App\Http\Requests\Absensi;

use Illuminate\Foundation\Http\FormRequest;

final class AbsensiDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_absensi' => 'required|integer',
            'id_jenis_absen' => 'required|integer',
            'waktu_mulai' => 'nullable|date',
            'waktu_selesai' => 'nullable|date',
            'durasi_jam' => 'nullable|numeric|min:0',
            'lokasi_pulang' => 'nullable|string|max:100',
        ];
    }

    public function attributes(): array
    {
        return [
            'id_absensi' => 'Absensi',
            'id_jenis_absen' => 'Jenis Absen',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
            'durasi_jam' => 'Durasi Jam',
            'lokasi_pulang' => 'Lokasi Pulang',
        ];
    }
}
