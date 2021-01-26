<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoRequest extends FormRequest
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
            'fechaCierre' => 'required|date|before:tomorrow',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'date' => 'El campo :attribute es inválido',
            'before' => 'El campo :attribute debe ser menor o igual que hoy',
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'nombre',
            'fechaCierre' => 'fecha cierre'
        ];
    }
}
