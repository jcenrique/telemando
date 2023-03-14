<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use OwenIt\Auditing\Contracts\Auditable;

class InventarioAtributo extends Model implements Auditable
{
   
    use HasFactory;
    use AsSource, Filterable, Attachable;
    
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;
    protected $table = 'inventario_atributos';


    protected $fillable = [
        'description',
        


        
    ];
    protected $allowedSorts = [
        'description',
    ];
    
    

    protected $allowedFilters = [
       
        'description',
    ];

    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }

}
