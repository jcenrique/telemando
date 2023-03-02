<?php

namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class Matriculas implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $letras =substr($value,-3);
      
        if (!ctype_upper($letras)){
            return false;
        }
       
        $numeros= substr($value,0,4);
      
       if(!ctype_digit($numeros)){
            return false;
       }

       $espacio= substr($value,4,1);
       
       if($espacio != ' '){
            return false;
       }

        return true;
    } 

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('La matrícula no cumple el formato  "#### AAA".');
    }
}
