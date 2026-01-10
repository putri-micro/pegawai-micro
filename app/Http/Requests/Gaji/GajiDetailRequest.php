<?php

namespace App\Http\Requests\Gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GajiDetailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'detail_id' => 'required|string|max:20',
            'komponen_id' => 'required|string|max:10',
            'nominal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'transaksi_id' => 'required|string|max:15',
        ];
    }

    public function attributes(): array
    {
        return [
            'detail_id' => 'ID Detail',
            'komponen_id' => 'ID Komponen',
            'nominal' => 'Nominal',
            'keterangan' => 'Keterangan',
            'transaksi_id' => 'ID Transaksi',
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
