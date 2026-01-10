<?php

namespace App\Http\Requests\Master;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MasterLiburRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tanggal' => 'required|date',
            'jenis_libur' => 'required|string|in:Nasional,Perusahaan',
            'nama_libur' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'tanggal' => 'Tanggal',
            'jenis_libur' => 'Jenis Libur',
            'nama_libur' => 'Nama Libur',
            'keterangan' => 'Keterangan',
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
            'tanggal.required' => 'Field :attribute wajib diisi.',
            'tanggal.date' => 'Field :attribute harus berupa tanggal yang valid.',
            'jenis_libur.required' => 'Field :attribute wajib diisi.',
            'jenis_libur.in' => 'Field :attribute harus Nasional atau Perusahaan.',
            'nama_libur.required' => 'Field :attribute wajib diisi.',
            'nama_libur.string' => 'Field :attribute harus berupa teks.',
            'nama_libur.max' => 'Field :attribute maksimal :max karakter.',
            'keterangan.string' => 'Field :attribute harus berupa teks.',
        ];
    }
}
