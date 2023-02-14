<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Elemento extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'elemento',
        'ubicacion_id',
        'equipo_id'
        
    ];
    protected $allowedSorts = [
        'elemento',
        'created_at',
        'updated_at'
    ];

    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class);
    }
    public function equipo()
    {
        return $this->hasOne(Equipo::class);
    }

    
    public function alarmas()
    {
        return $this->hasMany(Alarma::class);
    }
}
