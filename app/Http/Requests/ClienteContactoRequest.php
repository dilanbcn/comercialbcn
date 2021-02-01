<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteContactoRequest extends FormRequest
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
            'nombre' => 'required',
            'telefono' => 'required|digits:9|numeric|starts_with:2',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'digits' => 'El campo :attribute debe tener :digits digítos',
            'numeric' => 'El campo :attribute es inválido',
            'starts_with' => 'El campo :attribute debe comenzar con el número 2',
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'nombre',
            'telefono' => 'teléfono',
        ];
    }
}
