<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class NuevaTablaAlarmas extends Component
{
   use WithPagination;

   public $alarmas;

   public $elemento;
   


   public function mount()
   {
    
    

     
   }

   public function updatedElemento()
   {
    $this->alarmas =  \App\Models\Alarma::all()->paginate(15,['*']);
   }
    public function render()
    {
        return view('livewire.nueva-tabla-alarmas'  );
    }
}
