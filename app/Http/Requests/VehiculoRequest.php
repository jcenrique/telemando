<?php

namespace App\Http\Requests;

use App\Rules\Matriculas;
use Illuminate\Foundation\Http\FormRequest;

class VehiculoRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'vehiculo.matricula' => [
                'required',
                
                 new Matriculas                       
            ],
            
        ];
    }

    public function messages()
    {
       return [
        'vehiculo.matricula.required' => __('El campo matrícula no puede estar vacío')
       ];
    }
}
