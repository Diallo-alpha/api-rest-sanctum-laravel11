<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Mockery\Generator\StringManipulation\Pass\Pass;

class LoginRequest extends FormRequest
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
            'email' => "required|email",
            "password" => "required"
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return[
            "email.required" => "adresse mail vide",
            "email.email" => "verifier votre adresse mail",
            "password.required" => "mots de passe obligatire"

        ];
    }
}
