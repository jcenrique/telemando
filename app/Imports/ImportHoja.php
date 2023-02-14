<?php

namespace App\Imports;


use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ImportHoja implements WithMultipleSheets
{

    use   WithConditionalSheets;
    
    
    public $elemento_id;
    public function __construct($elemento_id){
        $this->elemento_id = $elemento_id;
       
    }

   
   
    public function conditionalSheets(): array
    {

  
        return [
            $this->conditionallySelectedSheets[0] => new AlarmasImport( $this->elemento_id)
        ];
    }
  
}
