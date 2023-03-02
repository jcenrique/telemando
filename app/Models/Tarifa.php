<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tarifa extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;

    
    protected $table ='tarifas';

    protected $fillable = [
        'tarifa',
        
    ];
    protected $allowedSorts = [
        'tarifa',
        'created_at',
        'updated_at'
    ];
    

    protected $allowedFilters = [
        'id',
        'tarifa',
      
    ];
    public function suministro()
    {
        return $this->belongsTo(Suministro::class);
    }
}
