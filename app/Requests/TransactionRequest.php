<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'payer' => ['required'],
            'payee' => ['required'],
            'value' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'payer.required' => 'Campo payer é obrigatorio',
            'payee.required' => 'Campo payee é obrigatorio',
            'value.required' => 'Campo value é obrigatorio',
        ];
    }
}
