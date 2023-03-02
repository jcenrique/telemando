<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Modelovehiculo extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='modelovehiculos';

    protected $fillable = [
        'modelo',
        'marcavehiculo_id'
        
    ];
    protected $allowedSorts = [
        'modelo',
        'marcavehiculo_id',
        'created_at',
        'updated_at'
    ];

  
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
    public function marca()
    {
        return $this->belongsTo(Marcavehiculo::class)->orderBy('marca','asc');
    }

  
}
