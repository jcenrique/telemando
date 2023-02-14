<?php

namespace App\Http\Requests;

use App\Rules\Uppercase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUbicacionRequest extends FormRequest
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
            'ubicacion.ubicacion' => [
                'required',
                new Uppercase,
              


            
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'ubicacion.ubicacion.required' => __('El campo ubicación  no puede estar vacío'),
            
            'ubicacion.ubicacion.unique' => __('El campo ubicación no puede estar repetido.'),
            
        ];
    }
}
