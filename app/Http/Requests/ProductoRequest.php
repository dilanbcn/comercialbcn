<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'archivo' => 'required|max:12000|mimes:pdf,xlsx,docx,csv',
            'nombre' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El campo :attribute es requerido',
            'max' => 'El peso del archivo supera el límite permitido (12 Mb).',
            'mimes' => 'Extensión de archivo no permitida.',
        ];
    }

    public function attributes()
    {
        return [
            'archivo' => 'archivo',
            'nombre' => 'nombre',
        ];
    }
}
