<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteComunicacionRequest extends FormRequest
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
        if ($this->route()->action['as'] == 'cliente-comunicacion.update'){
            return [
                'fechaContacto' => 'required|date|before_or_equal:today',
                'observaciones' => 'required',
                'tipoComunicacion' => 'required|exists:tipo_comunicaciones,id'
            ];
            
        } else {
            return [
                'cliente' => 'required|exists:clientes,id',
                'fechaContacto' => 'required|date|before_or_equal:today',
                'observaciones' => 'required',
                'tipoComunicacion' => 'required|exists:tipo_comunicaciones,id'
            ];
        }
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'exists' => 'El campo :attribute es inválido',
            'date' => 'El campo :attribute es una fecha inválida',
            'after_or_equal' => 'El campo :attribute debe ser mayor a la fecha de hoy',
        ];
    }

    public function attributes()
    {
        return [
            'cliente' => 'cliente',
            'fechaContacto' => 'fecha contacto',
            'observaciones' => 'observaciones',
            'tipoComunicacion' => 'tipo comunicación',
        ];
    }
}
