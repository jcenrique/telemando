<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tipovehiculo extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='tipovehiculos';

    protected $fillable = [
        'tipo',
        'description'
        
    ];
    protected $allowedSorts = [
        'tipo',
        'description',
        'created_at',
        'updated_at'
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

}
