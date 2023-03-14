<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use OwenIt\Auditing\Contracts\Auditable;

class Inventario extends Model implements Auditable
{
    use HasFactory;
    use AsSource, Filterable, Attachable;
    
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = 'inventarios';

    protected $fillable = [
        'inventario',
        'zona_id',
        'description'
        


        
    ];
    protected $allowedSorts = [
        'inventario',
        'zona_id',
        'description'
    ];
    
    

    protected $allowedFilters = [
       
        'inventario',
        'zona_id',
        'description'
    ];

  
    public function atributos()
    {
        return $this->hasMany(InventarioAtributo::class);
    }
}
