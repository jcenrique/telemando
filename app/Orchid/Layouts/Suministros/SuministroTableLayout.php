<?php

namespace App\Orchid\Layouts\Suministros;

use App\Models\Relacion;
use App\Models\Suministro;
use App\Models\Tarifa;
use App\Models\Tension;
use App\Models\Tipo;
use App\Models\Zona;
use App\Orchid\Filters\ZonaQueryFilter;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SuministroTableLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'suministros';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {

      //  dd(Suministro::all('poblacion')->unique('poblacion')->pluck('poblacion')->toArray());
        $col_poblaciones= Suministro::all('poblacion')->unique('poblacion')->sort()->pluck('poblacion');
        $array_poblaciones=[];
        foreach ($col_poblaciones as $key => $value) {
            $array_poblaciones=$array_poblaciones +[$value => $value] ;
        }
        $col_medidas= Suministro::all('medida')->unique('medida')->sort()->pluck('medida');
        $array_medidas=[];
        foreach ($col_medidas as $key => $value) {
            $array_medidas=$array_medidas +[$value => $value] ;
        }
        $col_icp= Suministro::all('icp')->unique('icp')->sort()->pluck('icp');
        $array_icp=[];
        foreach ($col_icp as $key => $value) {
            $array_icp=$array_icp +[$value => $value] ;
        }
        $col_contador= Suministro::all('contador')->unique('contador')->sort()->pluck('contador');
        $array_contador=[];
        foreach ($col_contador as $key => $value) {
            $array_contador=$array_contador +[$value => $value] ;
        }
        
        $col_instalaciones= Suministro::all('instalacion')->unique('instalacion')->sort()->pluck('instalacion')->sort();
        $array_instalaciones=[];
        foreach ($col_instalaciones as $key => $value) {
            $array_instalaciones=$array_instalaciones +[$value => $value] ;
        }
        
        
       //dd($array_poblaciones);
        return [

           // TD::make('id'),
           TD::make('position', __('Posición'))->sort(),
           TD::make('CUP', 'CUP')->sort()
            
                ->render(fn (Suministro $suministro) => 
                        Link::make($suministro->CUP)
                           
                                
                        ->style('color:red;background-color:rgb(255, 0, 0, .1);border-radius:8px; font-weight:bold;')
                ->route('platform.suministro.edit', $suministro->id)),
            TD::make('zona_id',__('Zona'))->sort()->filter(TD::FILTER_SELECT, Zona::all('id', 'zona')->pluck( 'zona','id',)->toArray())
            ->render(function ($model) {
                return Zona::find($model->zona_id)->zona;
            }),

            TD::make('poblacion', __('Población'))->sort()->filter(TD::FILTER_SELECT, $array_poblaciones)->width('200px'),
            TD::make('direccion' , __('Direccion'))->sort(),
            TD::make('instalacion' ,__('Instalación'))->sort()->filter(TD::FILTER_SELECT,$array_instalaciones),
            TD::make('tipo_id',__('Tipo'))->sort()->filter(TD::FILTER_SELECT, Tipo::all('id', 'tipo')->pluck( 'tipo','id',)->toArray())
            ->render(function ($model) {
                if($model->tipo_id){
                    return Tipo::find($model->tipo_id)->tipo;
                }
            }),
            

            TD::make('contrato',__('Contrato')),
            TD::make('num_contador',__('Num contador')),
            TD::make('telegestion',__('Telegestión'))->Filter(TD::FILTER_SELECT,['NO' ,'SÍ'])
            ->render(function ($model) {
             
                return $model->telegestion ==0 ? 'NO':'SÍ';
                
            }),
            TD::make('tarifa_id',__('Tarifa'))->sort()->filter(TD::FILTER_SELECT, Tarifa::all('id', 'tarifa')->pluck( 'tarifa','id',)->toArray())
            ->render(function ($model) {
                return Tarifa::find($model->tarifa_id)->tarifa;
            }),
            TD::make('P1'),
            TD::make('P2'),
            TD::make('P3'),
            TD::make('P4'),
            TD::make('P5'),
            TD::make('P6'),
            TD::make('tension_id',__('Tensión'))->sort()->filter(TD::FILTER_SELECT, Tension::all('id', 'tension')->pluck( 'tension','id',)->toArray())
            ->render(function ($model) {
                return Tension::find($model->tension_id)->tension;
            }),
            TD::make('medida',__('Medida'))->sort()->filter(TD::FILTER_SELECT,$array_medidas),
            TD::make('relacion_id',__('Relación'))->sort()->filter(TD::FILTER_SELECT, Relacion::all('id', 'relacion')->pluck( 'relacion','id',)->toArray())
            ->render(function ($model) {
                if($model->relacion_id){
                return Relacion::find($model->relacion_id)->relacion;
                }
            }),
            TD::make('icp',__('ICP'))->sort()->filter(TD::FILTER_SELECT,$array_icp),
            TD::make('comercializadora',__('Comercializadora'))->sort()->filter(TD::FILTER_SELECT,['CLIENTES','CUR']),
            TD::make('contador',__('Contador'))->sort()->filter(TD::FILTER_SELECT,$array_contador),
            TD::make('observacion',__('Observación')),

        ];
    }
    public function total():array
{
    return [
        TD::make('total')
            ->align(TD::ALIGN_RIGHT)
            ->colspan(2)
            ->render(function () {
                return 'Suminsitros totales registrados:  <strong>' . Suministro::all()->count() . '</strong>';
            }),

        TD::make('total_count')
            ->align(TD::ALIGN_RIGHT),

        TD::make('total_active_count')
            ->align(TD::ALIGN_RIGHT),
    ];
} 

protected function hoverable(): bool
{
    return true;
}
}
