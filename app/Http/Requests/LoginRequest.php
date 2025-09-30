<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email' => 'required|min:3|max: 128 | email',
            'password' => 'required|max:64',
            'g-recaptcha-response' => 'required|string',
        ];
    }

    /**
     * Get the custom messages for the validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [

            'email.email' => 'L\'adresse e-mail est invalide.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.min' => 'L\'e-maill doit contenir au minimum 3 caractères.',
            'email.max' => 'L\'e-maill doit contenir au maximum 128 caractères.',
            'password.required' => 'Le mot de passe est requis.',
            'password.max' => 'Le nom complet doit contenir au maximum 64 caractères.',
            'g-recaptcha-response.required' => 'Veuillez cocher la case "Je ne suis pas un robot".',
            'g-recaptcha-response.string' => 'Le reCAPTCHA est invalide.',
        ];
    }
}
