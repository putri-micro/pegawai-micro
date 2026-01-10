<?php

namespace App\Http\Requests\Absensi;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AbsenJenisRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_absen' => 'required|string|max:50',
            'kategori' => 'required|in:NORMAL,IZIN,SAKIT,ALPHA,CUTI,TELAT',
            'potong_gaji' => 'nullable|integer|in:0,1',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'potong_gaji' => $this->has('potong_gaji') ? 1 : 0,
        ]);
    }

    public function attributes(): array
    {
        return [
            'nama_absen' => 'Nama Absen',
            'kategori' => 'Kategori',
            'potong_gaji' => 'Potong Gaji',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()->messages(),
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
            'required' => 'Field :attribute wajib diisi.',
            'string' => 'Field :attribute harus berupa teks.',
            'max' => 'Field :attribute maksimal :max karakter.',
            'in' => 'Field :attribute pilihan tidak valid.',
            'integer' => 'Field :attribute harus berupa angka.',
        ];
    }
}
