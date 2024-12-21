<?php

namespace App\Http\Requests\User\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            ],
            'email' => [
                'required',
                'max:255',
                Rule::unique('users')->where('company_id', auth()->user()->company_id),
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('roles', 'id')
                    ->where('company_id', auth()->user()->company_id),
            ],
            'avatar_id' => [
                'nullable',
                'integer',
                Rule::exists('uploads', 'id')->whereNull('field')
                    ->whereNull('uploadable_id')
                    ->whereNull('uploadable_type')
            ]
        ];
    }
}
