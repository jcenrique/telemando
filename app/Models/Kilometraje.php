<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Kilometraje extends Model
{
    use HasFactory;
    use AsSource, Filterable;
  
    
    protected $table ='kilometrajes';

    protected $fillable = [
        'kilometraje',
        'vehiculo_id',
        'fecha',
        'created_at',
        'updated_at'
        
    ];
    protected $allowedSorts = [
        'kilometraje',
        'vehiculo_id',
        'fecha',
        'created_at',
        'updated_at'
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
