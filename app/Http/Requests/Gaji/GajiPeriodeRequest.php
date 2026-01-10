<?php

namespace App\Http\Requests\Gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GajiPeriodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periode_id' => 'required|string|max:15',
            'tahun' => 'required|integer|digits:4',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:DRAFT,FINAL,CLOSED',
        ];
    }

    public function attributes(): array
    {
        return [
            'periode_id' => 'ID Periode',
            'tahun' => 'Tahun',
            'tanggal_mulai' => 'Tanggal Mulai',
            'tanggal_selesai' => 'Tanggal Selesai',
            'status' => 'Status',
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
            'date' => 'Field :attribute harus berupa tanggal.',
            'after_or_equal' => 'Field :attribute harus setelah atau sama dengan Tanggal Mulai.',
            'digits' => 'Field :attribute harus terdiri dari :digits digit.',
        ];
    }
}
