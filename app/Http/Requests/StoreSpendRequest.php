<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpendRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'amount' => 'required|numeric|between:0,99999999.99',
            'date' => 'required|date|before_or_equal:today',
            'category' => 'nullable|string|max:255',
            'payment_method' => 'nullable|in:credit_card,debit_card,money,pix',
            'description' => 'nullable|string|max:500',
            'user_id' => 'required|exists:users,id',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'amount.required' => 'O valor é obrigatório.',
            'amount.numeric' => 'O valor deve ser um número.',
            'amount.between' => 'O valor deve estar entre 0 e 99999999.99.',
            'date.date' => 'A data deve ser uma data válida.',
            'date.before_or_equal' => 'A data deve ser hoje ou uma data passada.',
            'date.required' => 'A data é obrigatória.',
            'payment_method.in' => 'O método de pagamento deve ser um dos seguintes: crédito, débito, dinheiro ou pix.',
        ];
    }
    protected function prepareForValidation(): void
    {
        if ($this->has('amount')) {
            $amount = str_replace(',', '.', $this->input('amount'));
            $this->merge([
                'amount' => number_format((float)$amount, 2, '.', ''),
            ]);
        }
    }
}
