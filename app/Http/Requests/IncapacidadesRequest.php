<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IncapacidadesRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'dias_incapacidad' => 'required|integer',
            'fecha_inicio_incapacidad' => 'required|date',
            'aplica_cobro' => 'required|boolean',
            'entidad_afiliada' => 'required|string',
            'tipo_incapacidad' => 'required|string',
            'tipo_incapacidad_reportada' => 'required|string',
            'image' => 'required|image|max:2048',
        ];
    }
}
