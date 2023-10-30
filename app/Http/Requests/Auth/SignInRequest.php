<?php

namespace App\Http\Requests\Auth;

use App\Traits\ErrorResponseJson;
use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    use ErrorResponseJson;
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
            'email' => 'required|string|email:rfc,dns|max:199',
            'password' => 'required'
        ];
    }
}
