<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInfaqRekeningRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
{
    return true;
}

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_bank' => 'required|string|max:255',
            'nomor_rekening' => 'required|string|max:50|unique:infaq_rekening',
            'nama_pemilik' => 'required|string|max:255',
            'qris_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nama_bank.required' => 'Nama bank harus diisi',
            'nama_bank.string' => 'Nama bank harus berupa teks',
            'nama_bank.max' => 'Nama bank tidak boleh lebih dari 255 karakter',
            'nomor_rekening.required' => 'Nomor rekening harus diisi',
            'nomor_rekening.string' => 'Nomor rekening harus berupa teks',
            'nomor_rekening.max' => 'Nomor rekening tidak boleh lebih dari 50 karakter',
            'nomor_rekening.unique' => 'Nomor rekening sudah terdaftar',
            'nama_pemilik.required' => 'Nama pemilik harus diisi',
            'nama_pemilik.string' => 'Nama pemilik harus berupa teks',
            'nama_pemilik.max' => 'Nama pemilik tidak boleh lebih dari 255 karakter',
            'qris_image.image' => 'QRIS harus berupa gambar',
            'qris_image.mimes' => 'Format QRIS harus: jpeg, png, jpg, atau webp',
            'qris_image.max' => 'Ukuran QRIS tidak boleh lebih dari 2MB',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nama_bank' => 'Nama Bank',
            'nomor_rekening' => 'Nomor Rekening',
            'nama_pemilik' => 'Nama Pemilik',
            'qris_image' => 'Gambar QRIS',
            'is_active' => 'Status Aktif',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}
