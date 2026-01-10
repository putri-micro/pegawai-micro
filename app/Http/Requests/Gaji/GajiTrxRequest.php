<?php

namespace App\Http\Requests\Gaji;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GajiTrxRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaksi_id' => 'required|string|max:50',
            'periode_id' => 'required|string|max:20',
            'total_penghasil' => 'required|numeric|min:0',
            'total_potongan' => 'required|numeric|min:0',
            'total_dibayar' => 'required|numeric|min:0',
            'id_sdm' => 'nullable|integer',
        ];
    }

    public function attributes(): array
    {
        return [
            'transaksi_id' => 'ID Transaksi',
            'periode_id' => 'ID Periode',
            'total_penghasil' => 'Total Penghasilan',
            'total_potongan' => 'Total Potongan',
            'total_dibayar' => 'Total Dibayar',
            'id_sdm' => 'ID SDM',
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
