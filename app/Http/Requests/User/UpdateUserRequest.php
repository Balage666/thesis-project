<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Helper;

class UpdateUserRequest extends FormRequest
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
        $nameRegex = Helper::GetStrictNameRegex();
        return [
            'name' => ['required', 'unique:users,email', "regex:$nameRegex"],
            'email' => ['required', 'email'],
            'roles' => ['required', 'min:1']
        ];
    }
}
