<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class RegisterRequest extends FormRequest
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
            'nom' => 'required|min:4|max:60',
            'prenom' => 'required|min:4|max:150',
            'role' => 'required|in:admin,personnel,membre',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:10',
        ];
    }

      /**
     * Get the validation erros messages  rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function messages(): array
    {
        return[
            "nom.required" => "veiller saisir votre nom",
            "nom.min" => "le nom doit contenir minimum 4 lettres",
            "nom.max" => "le nom ne doit pas depasser 60 caracacters",
            "prenom.required" => "vieller indiquer votre prenom",
            "prenom.min" => "le prnom doit contenir minimum 4 caracters",
            "prenom.max" => "le prenom est trop long resume",
            "email.required" => "veiller saisir votre email",
            "email.email" => "le mail n'est pas valide",
            "email.unique" => "Email existe déja dans la base de donnée",
            "password.required" => "veiller saisir votre mots de passe",
            "password.min" => "le mots de passe doit contanr minimum 5 character",
            "password.max" => "mots de passe trop long resume"

        ];

    }
}
