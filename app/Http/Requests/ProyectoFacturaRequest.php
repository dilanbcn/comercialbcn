<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProyectoFacturaRequest extends FormRequest
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
            'fechaFacturacion' => 'required|date|date_format:Y-m-d|before:tomorrow',
            'fechaPago' => 'required|date|date_format:Y-m-d|before:tomorrow|after_or_equal:fechaFacturacion',
            'inscripcionSence' => 'required',
            'estado' => 'required|exists:com_estado_facturas,id',
            'montoVenta' => 'required|regex:/^\d{1,3}(?:\.\d\d\d)*(?:,\d{1,2})?$/',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Requerido',
            'date' => 'Fecha inválida',
            'date_format' => 'El formato de la fecha es inválido',
            'before' => 'Debe ser menor o igual que hoy',
            'after_or_equal' => 'Debe ser mayor a la fecha de facturación',
        ];
    }

    public function attributes()
    {
        return [
            'fechaFacturacion' => 'fecha facturación',
            'fechaPago' => 'fecha pago',
            'inscripcionSence' => 'inscripción SENCE',
            'estado' => 'estado',
        ];
    }
}
