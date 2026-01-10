<?php

namespace App\Http\Requests\Gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TarifLemburRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tarif_id' => 'required|string|max:10',
            'jenis_lembur' => 'required|in:BIASA,LIBUR',
            'tarif_per_jam' => 'required|numeric|min:0',
            'berlaku_mulai' => 'required|date',
        ];
    }

    public function attributes(): array
    {
        return [
            'tarif_id' => 'ID Tarif',
            'jenis_lembur' => 'Jenis Lembur',
            'tarif_per_jam' => 'Tarif per Jam',
            'berlaku_mulai' => 'Berlaku Mulai',
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
            'numeric' => 'Field :attribute harus berupa angka.',
            'date' => 'Field :attribute harus berupa tanggal valid.',
        ];
    }
}
