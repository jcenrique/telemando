<?php

namespace App\Orchid\Screens\Vehiculos;

use App\Imports\RepostajesImport;
use App\Models\Departamento;
use App\Models\Kilometraje;
use App\Models\Repostaje;
use App\Orchid\Filters\MatriculaFilter;
use App\Orchid\Filters\RepostajeMatriculaFilter;
use App\Orchid\Layouts\Vehiculos\RepostajeVehiculoLayoutTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class RespostajesVehiculosScreen extends Screen
{

    public $roles_permitidos;
  
   public $repostajes_importados;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {

        $this->roles_permitidos = Auth::user()->getRoles()->whereIn('slug', ['flota', 'admin'])->count();
        

        return [
            'repostajes' => Repostaje::with('vehiculo')->filters()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return __('Respostajes Vehículo');
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make(__('Importar'))
            ->modal('abrirFicheroExcel')
            ->method('importar')
                      
            ->icon('upload'),
         ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
//$builder = Repostaje::filters();
  //     dump($builder->get());
        return [

           

           
          RepostajeVehiculoLayoutTable::class,
            Layout::modal('abrirFicheroExcel', [
                Layout::rows([

                    Input::make('archivo')->type('file')
                    ->title(__('Selecciona un archivo Excel de repostajes de vehículos'))
                    ->required(),
                
                Button::make('Importar')
                    ->method('importar')



                ])

            ])->title(__('Cargar fichero Excel de repostajes')),
           
       
           

           // Layout::view('admin.kilometraje-table', ['repostajes_importados' =>$this->repostajes_importados])
            
        ];
    }

    public function importar(Request $request)
    {
      

        //borrar registros anteriores
        $fecha_importacion =Carbon::now()->format('Y-m-d');
        Repostaje::where('fecha_importacion', $fecha_importacion)->delete();

     

        //cargar el archivo , falta validarlo para evitar errores

        if ($request->archivo->isValid()) {
            $fileName = $request->archivo->getClientOriginalName();
            $filePath = '/public/' . $request->archivo->storeAs('uploads', $fileName, 'public');
        }
        //borrar todos los emenetos y alarmas en cascada de la ubicacion elegida y equipo elegido
     

        //leer las hojas y crear lon nuevos elementos en la DB 


           
            $importHoja = new RepostajesImport( $fecha_importacion );

           
           Excel::import($importHoja, $filePath);
             $this->repostajes_importados=$importHoja->data;

 

        Toast::info(__('Repostajes importados a la DB!.'));
    }
    
}
