<?php

namespace App\Http\Requests\User\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
                Rule::unique('roles')
                    ->where('company_id', auth()->user()->company_id)
                    ->ignore($this->route('id'), 'id')
            ],
            'permission_ids' => [
                'nullable',
                'array'
            ],
            'permission_ids.*' => [
                'integer',
            ]
        ];
    }
}
