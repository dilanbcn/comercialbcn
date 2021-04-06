<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required', new CurrentPasswordCheckRule],
            'password' => ['required', 'min:8', 'confirmed', 'different:old_password', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)([A-Za-z\d$@$!%*?&]|[^ ])$/'],
            'password_confirmation' => ['required', 'min:8'],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido.',
            'min' => 'El campo :attribute debe tener al menos 8 caracteres.',
            'confirmed' => 'La contraseña nueva no coincide con su confirmación.',
            'different' => 'La nueva contraseña debe ser diferente a la contraseña anterior.',
            'regex' => 'La nueva contraseña debe contener mayúsculas, minúsculas, al menos un dígito numérico y sin espacios en blanco.',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'old_password' => 'Contraseña actual',
            'password' => 'Contraseña',
            'password_confirmation' => 'Confirmar Contraseña',
        ];
    }
}
