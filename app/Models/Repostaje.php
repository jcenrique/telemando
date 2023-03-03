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
        'litros',
        'importe',
        'vehiculo_id',
        'fecha'
        
    ];
    protected $allowedSorts = [
        'litros',
        'importe',
        'fecha',
        'created_at',
        'updated_at'
    ];

    public function vehiculos()
    {
        return $this->belongsTo(Vehiculo::class);
    }
}
