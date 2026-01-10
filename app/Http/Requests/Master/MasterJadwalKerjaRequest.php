<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class MasterJadwalKerjaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_jadwal' => ['required', 'string', 'max:100'],
            'jam_masuk' => ['required'],
            'jam_pulang' => ['required'],
            'istirahat_mulai' => ['nullable'],
            'istirahat_selesai' => ['nullable'],
            'toleransi_menit' => ['required', 'integer', 'min:0'],
            'id_libur' => ['nullable', 'exists:master_libur,id_libur'],
            'keterangan' => ['nullable', 'string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nama_jadwal' => 'Nama Jadwal',
            'jam_masuk' => 'Jam Masuk',
            'jam_pulang' => 'Jam Pulang',
            'istirahat_mulai' => 'Istirahat Mulai',
            'istirahat_selesai' => 'Istirahat Selesai',
            'toleransi_menit' => 'Toleransi (Menit)',
            'id_libur' => 'Referensi Libur',
            'keterangan' => 'Keterangan',
        ];
    }
}
