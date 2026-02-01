<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
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
            'nominal' => 'required|integer|min:1000',
            'rekening' => 'required|string|exists:wallets,rekening',
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
            'nominal.required' => 'Nominal harus diisi',
            'nominal.integer' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal Rp 1.000',
            'rekening.required' => 'Nomor rekening harus diisi',
            'rekening.exists' => 'Nomor rekening tidak valid',
        ];
    }
}
