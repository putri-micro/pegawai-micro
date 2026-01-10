<?php

namespace App\Http\Requests\Gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class KomponenGajiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'komponen_id' => 'required|string|max:10',
            'nama_komponen' => 'required|string|max:100',
            'jenis' => 'required|in:PENGHASIL,POTONGAN',
            'deskripsi' => 'nullable|string',
            'is_umum' => 'boolean',
            'umum_id' => 'nullable|string|max:10',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_umum' => $this->has('is_umum') ? 1 : 0,
        ]);
    }

    public function attributes(): array
    {
        return [
            'komponen_id' => 'ID Komponen',
            'nama_komponen' => 'Nama Komponen',
            'jenis' => 'Jenis',
            'deskripsi' => 'Deskripsi',
            'is_umum' => 'Gaji Umum?',
            'umum_id' => 'ID Umum',
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
            'in' => 'Field :attribute harus salah satu dari: :values.',
            'max' => 'Field :attribute maksimal :max karakter.',
        ];
    }
}
