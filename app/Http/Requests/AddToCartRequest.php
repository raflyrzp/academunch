<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jumlah_produk' => 'required|numeric|min:1',
            'id_produk' => 'required|exists:produks,id',
            'id_user' => 'required|exists:users,id',
            'harga' => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'jumlah_produk.required' => 'Jumlah produk harus diisi',
            'jumlah_produk.numeric' => 'Jumlah produk harus berupa angka',
            'jumlah_produk.min' => 'Jumlah produk minimal 1',
            'id_produk.required' => 'Produk harus dipilih',
            'id_produk.exists' => 'Produk tidak ditemukan',
            'id_user.required' => 'User tidak valid',
            'id_user.exists' => 'User tidak ditemukan',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
        ];
    }
}
