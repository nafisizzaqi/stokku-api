<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $supplier = $this->route('supplier');

        return [
            'name' => [
                $supplier ? 'sometimes' : 'required',
                'string',
                'max:255'
            ],
            'email' => [
                $supplier ? 'sometimes' : 'required',
                'string',
                'email',
                Rule::unique('suppliers', 'email')->ignore($supplier)->whereNull('deleted_at')
            ],
            'phone' => [
                $supplier ? 'sometimes' : 'required',
                'string'
            ],
            'address' => [
                $supplier ? 'sometimes' : 'required',
                'string'
            ]
        ];
    }
}
