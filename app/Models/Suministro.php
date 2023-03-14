<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Rutorika\Sortable\SortableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Suministro extends Model implements Auditable
{
    use HasFactory;
    use AsSource, Filterable, Attachable;
    use SortableTrait;
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;


    protected $fillable = [
        'position',
        'zona_id',
        'poblacion',
        'direccion',
        'instalacion',
        'tipo_id',
        'CUP',
        'contrato',
        'num_contador',
        'tarifa_id',
        'P1',
        'P2',
        'P3',
        'P4',
        'P5',
        'P6',
        'tension_id',
        'medida',
        'relacion_id',
        'icp',
        'contador',
        'telegestion',
        'comercializadora',
        'observacion',


        
    ];
    protected $allowedSorts = [
        'position',
        'zona_id',
        'poblacion',
        'direccion',
        'instalacion',
        'tipo_id',
        'CUP',
        'contrato',
        'num_contador',
        'tarifa_id',
        'P1',
        'P2',
        'P3',
        'P4',
        'P5',
        'P6',
        'tension_id',
        'medida',
        'relacion_id',
        'icp',
        'contador',
        'telegestion',
        'comercializadora',
        'observacion',
    ];
    
    

    protected $allowedFilters = [
       
        'zona_id',
        'poblacion',
        'direccion',
        'instalacion',
        'tipo_id',
        'CUP',
        'contrato',
        'num_contador',
        'tarifa_id',
        
        'tension_id',
        'medida',
        'relacion_id',
        'icp',
        'contador',
        'telegestion',
        'comercializadora',
        'observacion',
      
    ];

    public function relacion()
    {
        return $this->belongsTo(Relacion::class);
    }

    public function tarifa()
    {
        return $this->belongsTo(Tarifa::class);
    }

    public function tension()
    {
        return $this->belongsTo(Tension::class);
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }
}
