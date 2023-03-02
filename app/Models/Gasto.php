<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Gasto extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='gastos';

    protected $fillable = [
        'gasto',
        'vehiculo_id',
        'fecha'
        
    ];
    protected $allowedSorts = [
        'gasto',
        'vehiculo_id',
        'fecha',
        'created_at',
        'updated_at'
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
}
