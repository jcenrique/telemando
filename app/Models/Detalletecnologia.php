<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Detalletecnologia extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='detalletecnologias';

    protected $fillable = [
        'detalle',
        'tecnologia_id',
        
    ];
    protected $allowedSorts = [
        'detalle',
        'tecnologia_id',
        'created_at',
        'updated_at'
    ];

    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function tecnologia()
    {
        return $this->belongsTo(Tecnologia::class);
    }
}
