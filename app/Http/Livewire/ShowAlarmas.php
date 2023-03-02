<?php

namespace App\Http\Livewire;

use App\Models\Elemento;
use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Models\Zona;

use Livewire\Component;
use Livewire\WithPagination;
use Orchid\Support\Facades\Alert;

class ShowAlarmas extends Component
{
    use WithPagination;
    
    public $tabs;

    public $zonas;
   
    public $zona_id;

    public $ubicaciones;

    public $ubicacion_id;

    public $ubicacion;

    public $equipos;

    public $equipo;

    public $equipo_id;

    public $elementos;

    public $elemento; 

    public $elemento_id;

    public $array_elementos;

    protected $paginationTheme = 'bootstrap';
    public $busquedaUbicacion="";

public $classTab;

    public function mount()
    {
        $this->zonas = Zona::all()->sortBy("zona");

      
    }
    public function render()

    {
        return view('livewire.show-alarmas');
    }

    public function updatedZonaId($zona_id)
    {
        $this->ubicaciones = null;
        $this->ubicaciones = Ubicacion::where('zona_id', $zona_id)->orderBy('ubicacion', 'asc')->search('ubicacion', $this->busquedaUbicacion)->get();

        $this->equipos =null;
        $this->elementos =null;
        $this->equipo =null;
        $this->ubicacion =null;
        $this->array_elementos =null;
    }


     public function updatedUbicacionId($ubicacion_id)
    {
   
        $this->ubicacion = Ubicacion::with('equipos','elementos')->find($ubicacion_id);

            
      

        $this->equipos = $this->ubicacion->equipos;
     
       
        $this->elementos =null;
        $this->equipo =null;
        $this->array_elementos =null;
        
      
      
    }

    public function updatedEquipoId($equipo_id)

    {

        $this->equipo = Equipo::find($equipo_id);

        $this->elementos = Elemento::where('ubicacion_id',  $this->ubicacion->id)
                                ->where('equipo_id',  $equipo_id)
                                ->with('alarmas')
                                ->orderBy('elemento', 'asc')
                                ->get();
        $this->array_elementos =json_encode( \Illuminate\Support\Arr::pluck($this->elementos->toArray(),['elemento']));
       
    }

    public function elementoClick($elemento_id)

    {

        $this->emitTo($elemento_id, 'clickElemento');
        $this->classTab='text-red-500';
       // dd($elemento_id);
    }

    public function resetTabs()
    {
     
        $this->resetPage();
    }
   

}
