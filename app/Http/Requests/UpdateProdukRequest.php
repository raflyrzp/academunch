<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProdukRequest extends FormRequest
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
        $produkId = $this->route('produk');

        return [
            'nama_produk' => [
                'required',
                'string',
                'max:255',
                Rule::unique('produks', 'nama_produk')->ignore($produkId),
            ],
            'id_kategori' => 'required|exists:kategoris,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|numeric|min:0',
            'desc' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
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
            'nama_produk.required' => 'Nama produk harus diisi',
            'nama_produk.unique' => 'Nama produk sudah digunakan',
            'id_kategori.required' => 'Kategori harus dipilih',
            'id_kategori.exists' => 'Kategori tidak valid',
            'harga.required' => 'Harga harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga tidak boleh negatif',
            'stok.required' => 'Stok harus diisi',
            'stok.numeric' => 'Stok harus berupa angka',
            'desc.required' => 'Deskripsi harus diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, jpg, atau png',
            'foto.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
