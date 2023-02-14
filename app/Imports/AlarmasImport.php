<?php

namespace App\Imports;

use App\Models\Alarma;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToModel;



class AlarmasImport implements ToModel ,SkipsEmptyRows
{
    use RemembersRowNumber,SkipsFailures;
    
    /**
    * @param array $row


    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public $elemento_id;
    public function __construct($elemento_id){
        $this->elemento_id = $elemento_id;
       
    }

    public function model(array $row)
    {
       
      if($this->getRowNumber()==1) return; 
    
        return new Alarma([
            'alarma' => $row[0],
            'origen' => $row[1] ,
            'consecuencia' => $row[2],
            'actuacion' =>$row[3],
           
            'elemento_id' =>$this->elemento_id,
        ]);
    }
   
   
	/**
	 * @return array
	 */
	



}
