<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Equipo extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'equipo',
        
    ];
    protected $allowedSorts = [
        'equipo',
        'created_at',
        'updated_at'
    ];

    public function ubicaciones()
    {
        return $this->belongsToMany(Ubicacion::class);
    }
    public function elementos()
    {
        return $this->belongsTo(Elemento::class);
    }

}
