<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tipo extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    
    protected $table ='tipos';

    protected $fillable = [
        'tipo',
        
    ];
    protected $allowedSorts = [
        'tipo',
        'created_at',
        'updated_at'
    ];
    

    protected $allowedFilters = [
        'id',
        'tipo',
      
    ];
    public function suministros()
    {
        return $this->belongsTo(Suministro::class);
    }

}
