<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Tension extends Model
{
    use HasFactory;
    use AsSource, Filterable, Attachable;
    protected $table ='tensiones';

    
  

    protected $fillable = [
        'tension',
        
    ];
    protected $allowedSorts = [
        'tension',
        'created_at',
        'updated_at'
    ];
    

    protected $allowedFilters = [
        'id',
        'tension',
      
    ];
    public function suministros()
    {
        return $this->belongsTo(Suministro::class);
    }
}
