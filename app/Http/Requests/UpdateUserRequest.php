<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'email' => "required|email|max:255|unique:users,email,{$this->user()->id}",
            'level' => 'required|in:0,1',
            'password' => 'string',
            'avatar_new' => 'nullable|image',
            'avatar_old' => 'nullable|string',
        ];
    }
}
