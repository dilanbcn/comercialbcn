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
            'fechaFacturacion' => 'required|date|date_format:Y-m-d',
            // 'fechaFacturacion' => 'required|date|date_format:Y-m-d|before:tomorrow',
            // 'fechaPago' => 'required|date|date_format:Y-m-d|before:tomorrow|after_or_equal:fechaFacturacion',
            'inscripcionSence' => 'required',
            'estado' => 'required|exists:estado_facturas,id',
            'montoVenta' => 'required|regex:/^\d{1,3}(?:\.\d\d\d)*(?:,\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'date' => 'El campo :attribute es inválido',
            'before' => 'El campo :attribute debe ser menor o igual que hoy',
            'date_format' => 'El formato de la fecha es inválido',
            'after_or_equal' => 'Debe ser mayor a la fecha de facturación',
        ];
    }

    public function attributes()
    {
        return [
            'nombre' => 'nombre',
            'fechaCierre' => 'fecha cierre',
            'fechaFacturacion' => 'fecha facturación',
            'fechaPago' => 'fecha pago',
            'inscripcionSence' => 'inscripción SENCE',
            'estado' => 'estado',
        ];
    }

   
}
