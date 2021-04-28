<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificacionRequest extends FormRequest
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
            'mensaje' => 'required',
            'cliente' => 'required',
            'destino' => 'required|array',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'array' => 'El campo :attribute es inválido',
        ];
    }

    public function attributes()
    {
        return [
            'mensaje' => 'contenido',
            'cliente' => 'cliente',
            'destino' => 'destino'
        ];
    }
}
