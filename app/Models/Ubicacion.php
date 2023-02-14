<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Ubicacion extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    protected $table = 'ubicaciones';
    protected $fillable = [
        'ubicacion',
        'comentario',
        'zona_id',
        'id'
        
    ];
    protected $allowedSorts = [
        'ubicacion',
        'zona_id',
        'created_at',
        'updated_at'
    ];

    protected $allowedFilters = [
        'ubicacion',
        'zona_id'
    ];

    public function zona()
    {
        return $this->hasOne(Zona::class,'id' ,'zona_id');
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class)->orderBy('equipo','asc');
    }

    public function elementos()
    {
        return $this->hasMany(Elemento::class);
    }


}
