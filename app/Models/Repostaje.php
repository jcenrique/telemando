<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Repostaje extends Model
{
    use HasFactory;
    use AsSource, Filterable;
  
    
    protected $table ='repostajes';

    protected $fillable = [
        'vehiculo_id',
        'litros',
        'importe',
        'combustible',
        'kilometraje',
        'poblacion',
        'establecimiento',
       'fecha_importacion',
        'fecha'
        
    ];
    protected $allowedSorts = [
        'vehiculo_id',
        'litros',
        'importe',
        'combustible',
        'kilometraje',
        'poblacion',
        'establecimiento',
        'fecha_importacion',
        'fecha',
        'created_at',
        'updated_at',
    ];

    protected $allowedFilters  = [
        'vehiculo_id',
        'litros',
        'importe',
        'combustible',
        'kilometraje',
        'poblacion',
        'establecimiento',
        'fecha_importacion',
        'fecha',
        'created_at',
        'updated_at',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
