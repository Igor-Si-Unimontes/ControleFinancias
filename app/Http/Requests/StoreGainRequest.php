<?php

namespace App\Http\Requests;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreGainRequest extends FormRequest
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
            'name' => 'required|string|max:40',
            'amount' => 'required|numeric|between:0,99999999.99',
            'date' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:255',
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
            'description.max' => 'A descrição não pode exceder 255 caracteres.',
        ];
    }
}
