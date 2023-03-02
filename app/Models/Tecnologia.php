<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tecnologia extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='tecnologias';

    protected $fillable = [
        'tecnologia',
       
        
    ];
    protected $allowedSorts = [
        'tecnologia',
       
        'created_at',
        'updated_at'
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function detalles()
    {
       return $this->hasMany(Detalletecnologia::class);
    }
}
