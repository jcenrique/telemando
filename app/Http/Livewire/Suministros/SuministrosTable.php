<?php

namespace App\Http\Livewire\Suministros;

use App\Exports\SuministrosExport;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Zona;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

use Rappasoft\LaravelLivewireTables\Views\Filter;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Rappasoft\LaravelLivewireTables\Views\Filters\MultiSelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class SuministrosTable extends DataTableComponent
{
    protected $model = Suministro::class;
   // protected string $pageName = 'Suministros';
    protected string $tableName = 'Suministros';

    public int $perPage = 15;
    public array $perPageAccepted = [15, 30, 50, 100];
   
    public $columnSearch = [
        'poblacion' => null,
    ];
   
    public function configure(): void
    {
        $this->setPrimaryKey('id');

      
        
        $this->setTableAttributes([
            
            'class' => 'font-mono text-gray-600',


          ]);

          $this->setThAttributes(function(Column $column) {
            if ($column->isField('position')) {
              return [
                'style' => 'max-width:100px;',
                
              ];
            }
        
            return [];
          });

          $this->setTdAttributes(function(Column $column, $row, $columnIndex, $rowIndex) {
            if ($column->isField('position')) {
              return [
                'class' => 'text-center',
              ];
            }
        
            return [];
          });
          $this->setSecondaryHeaderTdAttributes(function(Column $column, $rows) {
               
                    return ['class' => 'bg-gray-600'];
              

               
            });

          
    }

    public function columns(): array
    {


        return [

            Column::make(__("Posición"), "position")
                ->sortable(),
            Column::make(__("Zona"), "zona.zona")
                ->sortable()->searchable()->hideIf(true),
            Column::make(__("Población"), "poblacion")
                ->hideIf(true)->searchable(),
                // ->secondaryHeader(function() {
                //     return view('livewire.tables.cells.input-search', ['field' => 'poblacion',  'field_text' => __('Población')]);
                // }),
            
                Column::make('Localización','poblacion')
                ->label(
                    fn($row, Column $column)  => '<strong class="text-gray-600">'. $row->poblacion . '</strong><br><small>'. $row->direccion .'</small>'
                )     
                 ->secondaryHeader(function() {
                     return view('livewire.tables.cells.input-search', ['field' => 'poblacion',  'field_text' => __('Población')]);
                 })->searchable()          
              ->html(),

            Column::make("Dirección", "direccion")
                ->sortable()->searchable()->hideIf(true),
            Column::make("Instalación", "instalacion")
                ->sortable()->searchable()
                ->html()
                ->secondaryHeader(function() {
                    return view('livewire.tables.cells.input-search', ['field' => 'instalacion',  'field_text' => __('Instalación')]);
                }),
            Column::make("Tipo Suministro", "tipo.tipo")
                ->sortable()->searchable(),
            Column::make("CUP", "CUP")
                ->sortable()->searchable()
                ->format(function($value) {
                    return '<div class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-red-100 text-red-800 py-1">' . $value. '</div>';
                })
                ->html(),

            Column::make("Contrato", "contrato")
                ->sortable(),
            Column::make("Num contador", "num_contador")
                ->sortable()->searchable(),
            Column::make("Tarifa", "tarifa.tarifa")
                ->sortable()->searchable(),
            Column::make("P1", "P1")
                ->sortable()->collapseOnTablet(),
            Column::make("P2", "P2")
                ->sortable()->collapseOnTablet(),
            Column::make("P3", "P3")
                ->sortable()->collapseOnTablet(),
            Column::make("P4", "P4")
                ->sortable()->collapseOnTablet(),
            Column::make("P5", "P5")
                ->sortable()->collapseOnTablet(),
            Column::make("P6", "P6")
                ->sortable()->collapseOnTablet(),
            Column::make("Tensión", "tension.tension")
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make("Medida", "medida")
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make("Relación", "relacion.relacion")
                ->sortable()->searchable()->collapseOnTablet(),
            Column::make("Icp", "icp")
                ->sortable()->searchable()
                ->html()
                ->secondaryHeader(function() {
                    return view('livewire.tables.cells.input-search', ['field' => 'icp',  'field_text' => __('ICP')]);
                })->collapseOnTablet(),
            Column::make("Contador", "contador")
                ->sortable()->searchable()
                ->html()
                ->secondaryHeader(function() {
                    return view('livewire.tables.cells.input-search', ['field' => 'contador',  'field_text' => __('Contador')]);
                })->collapseOnTablet(),
            Column::make("Observación", "observacion")
                ->sortable()->collapseOnTablet(),
            Column::make(__("Creado"), "created_at")
                ->sortable()->collapseOnTablet(),
            Column::make(__("Actualizado"), "updated_at")
                ->sortable()
                ->format(function($value) {
                    
                    return  $value->format('H:i d/m/Y');
                })->collapseOnTablet(),
        ];
    }
    public function builder(): Builder
    {
        return Suministro::query()
        ->when($this->columnSearch['poblacion'] ?? null, fn ($query, $poblacion) => $query->where('poblacion', 'like', '%' . $poblacion . '%'))
        ->when($this->columnSearch['instalacion'] ?? null, fn ($query, $instalacion) => $query->where('instalacion', 'like', '%' . $instalacion . '%'))
        ->when($this->columnSearch['contador'] ?? null, fn ($query, $contador) => $query->where('contador', 'like', '%' . $contador . '%'))
        ->when($this->columnSearch['icp'] ?? null, fn ($query, $icp) => $query->where('icp', 'like', '%' . $icp . '%'));
        
      
    }


    public function filters(): array
{
    return [
        MultiSelectFilter::make('Zonas')
        ->options(
            Zona::query()
                ->orderBy('zona')
                ->get()
                ->keyBy('id')
                ->map(fn($zona) => $zona->zona)
                ->toArray()
        )->filter(function(Builder $builder, array $values) {
            $builder->whereHas('zona', fn($query) => $query->whereIn('zonas.id', $values));
        }),
       
      
        MultiSelectFilter::make('Tarifas')
        ->options(
            Tarifa::query()
                ->orderBy('tarifa')
                ->get()
                ->keyBy('id')
                ->map(fn($tarifa) => $tarifa->tarifa)
                ->toArray()
        )->filter(function(Builder $builder, array $values) {
            $builder->whereHas('tarifa', fn($query) => $query->whereIn('tarifas.id', $values));
        }),    
    
        MultiSelectFilter::make('Tensión')
        ->options(
            Tension::query()
                ->orderBy('tension')
                ->get()
                ->keyBy('id')
                ->map(fn($tension) => $tension->tension)
                ->toArray()
        )->filter(function(Builder $builder, array $values) {
            $builder->whereHas('tension', fn($query) => $query->whereIn('tensiones.id', $values));
        }),   
    
    ];
}


public function exportar()
{
    
    $date= Suministro::get('updated_at')->sortByDesc('updated_at')->first()->updated_at;
    $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)
                                    ->format('Ymd H,i');
    

    return Excel::download(new SuministrosExport, $newDate . '_suministros.xlsx');
}
    
}
