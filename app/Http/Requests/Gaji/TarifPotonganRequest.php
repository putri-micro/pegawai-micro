<?php

namespace App\Http\Requests\Gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TarifPotonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'potongan_id' => 'required|string|max:10',
            'nama_potongan' => 'required|string|max:100',
            'tarif_per_kejadian' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'potongan_id' => 'ID Potongan',
            'nama_potongan' => 'Nama Potongan',
            'tarif_per_kejadian' => 'Tarif per Kejadian',
            'deskripsi' => 'Deskripsi',
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
            'max' => 'Field :attribute maksimal :max karakter.',
            'numeric' => 'Field :attribute harus berupa angka.',
        ];
    }
}
