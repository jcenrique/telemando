<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Relacion extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    protected $table ='relaciones';

    protected $fillable = [
        'relacion',
        
    ];
    protected $allowedSorts = [
        'relacion',
        'created_at',
        'updated_at'
    ];
    

    protected $allowedFilters = [
        'id',
        'relacion',
      
    ];
    public function suministros()
    {
        return $this->belongsTo(Suministro::class);
    }
}
