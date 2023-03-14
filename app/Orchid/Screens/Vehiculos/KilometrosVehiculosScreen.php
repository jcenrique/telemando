<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Models\Departamento;
use App\Models\Kilometraje;
use App\Models\User;
use App\Models\Vehiculo;
use App\Orchid\Layouts\Vehiculos\KilometrosVehiculoListener;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Orchid\Screen\Actions\Button;

use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

use Orchid\Support\Color;

class KilometrosVehiculosScreen extends Screen
{
    private $roles_permitidos;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     * 
     */
    public function query(): iterable
    {
        $this->roles_permitidos = Auth::user()->getRoles()->whereIn('slug', ['flota' ,'admin'])->count();
        $user_id =  Auth::user()->id;
        $user = User::with('departamentos')->where('id',$user_id)->first();
        $departamentos_id = $user->departamentos()->get()->pluck('id')->toArray();
        
      
        if($this->roles_permitidos == 0){
            $array_departamentos =   $departamentos_id ;
          
            if(sizeof( $array_departamentos) > 0) $this->roles_permitidos =1;
        }else{
            $array_departamentos = Departamento::all()->pluck('id')->toArray();
        }

   
        return [
        
        ];
    }

    public function permission(): ?iterable
    {
        return [
            'flota',
            'admin',
            'kilometros'
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Kilometros Vehículos');
    }
    public function description(): ?string
    {
        return __('Introducir los kilometros de los vehículos por departamento');
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Button::make('Guardar')
            ->icon('note')
            ->canSee($this->roles_permitidos>0)
            ->method('obtenerKilometros')
           ,
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
           KilometrosVehiculoListener::class
        ];
    }

    public function obtenerKilometros(Request $request){
            if($request['kilometros'] ==null){

                Alert::info(__('No hay registros de kilometros'));
                return redirect()->route('platform.vehiculos.kilometros');
            };
        //por cada array de kilometros
            //comprobar que los kilometros son iguales o superiores que la ultima lectura
            //comprobar que la fecha es superior a la ultima lectura
            //comprobar duplicados y rechazarlos
            
        $arrayKilometraje =$request['kilometros'];
        //eliminar duplicados
        
        $arrayKilometraje = $this->unique_multidim_array($arrayKilometraje,'vehiculo_id');
       $mensajeerror ='';
   
      // DB::transaction(function () use($mensajeerror,$arrayKilometraje) { //comenzar la transaccion 
       
        foreach ($arrayKilometraje as $key => $kilometraje) {
            
            
           $max_kilometros = Kilometraje::where('vehiculo_id', $kilometraje['vehiculo_id'])->get()->max('kilometraje');
           $max_fecha = Kilometraje::where('vehiculo_id', $kilometraje['vehiculo_id'])->get()->max('fecha');
         
           $ultima_fecha_registrada =is_null($max_fecha)? Carbon::createFromFormat('Y-m-d', '2000-01-01') : Carbon::createFromFormat('Y-m-d',$max_fecha);
           $fecha_introducida =Carbon::createFromFormat('Y-m-d', $kilometraje['fecha']);
    

         
            if(($max_kilometros> intval( $kilometraje['kilometraje'])) || ($ultima_fecha_registrada->gt($fecha_introducida)) ){
                //descartar datos si los kilometros o la fecha son inferiores a la ultima ocasion
                //registrar un mensaje con los errores
             
                if($max_kilometros >  intval( $kilometraje['kilometraje'])){
                 
                    $mensajeerror = $mensajeerror . 'Los datos de la matricula: <strong>' . Vehiculo::find($kilometraje['vehiculo_id'])->matricula . '</strong> , se han descartado por ser los kilometros inferirores al último registro<br>';
                }else{
                  
                    $mensajeerror = $mensajeerror . 'Los datos de la matricula: <strong>' . Vehiculo::find($kilometraje['vehiculo_id'])->matricula . '</strong> , se han descartado por ser la fecha inferior o igual al último registro<br>';
                }
               
            }else{
                //guardar los validos
                DB::table('kilometrajes')->insert([
                    'kilometraje' => $kilometraje['kilometraje'],
                    'vehiculo_id' => $kilometraje['vehiculo_id'],
                    'fecha' => $fecha_introducida,
                    'update_at' => Carbon::now(),
                    'created_at' => Carbon::now(),

                ]);

            }

           
        }//fin de la transaccion
       
   // });

  
        $color = $mensajeerror != '' ? Color::WARNING() :Color::SUCCESS();
        $mensaje =  $mensajeerror != '' ? $mensajeerror : __('Datos guardados correctamente');
        Alert::view('layouts.alert-personal', $color, [
            'mensaje' => $mensaje
        ]);
       // return redirect()->route('platform.vehiculos.kilometros');
    }

    public function asyncKilometros($departamento)
    {
        
        return[
            'departamento_id' => $departamento,
        ];
    }


  private  function unique_multidim_array($array, $key) {

        $temp_array = array();
    
        $i = 0;
    
        $key_array = array();
    
        
    
        foreach($array as $val) {
    
            if (!in_array($val[$key], $key_array)) {
    
                $key_array[$i] = $val[$key];
    
                $temp_array[$i] = $val;
    
            }
    
            $i++;
    
        }
    
        return $temp_array;
    
    }

    
}
