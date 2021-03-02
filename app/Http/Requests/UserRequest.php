<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'rol' => 'required|exists:com_roles,id',
            'rut' => 'required|cl_rut',
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => 'required|confirmed|email',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'exists' => 'El :attribute es inválido.',
            'cl_rut' => 'El :attribute es inválido.',
            'string' => 'El campo :attribute es inválido',
            'confirmed' => 'Los correos deben coincidir.',
            'email' => 'El campo :attribute debe ser un email válido.',
        ];
    }

    public function attributes()
    {
        return [
            'rol' => 'rol',
            'rut' => 'rut',
            'nombre' => 'nombre',
            'apellido' => 'apellido',
            'correo' => 'correo',
        ];
    }
}
