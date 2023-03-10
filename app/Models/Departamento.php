<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Departamento extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='departamentos';

    protected $fillable = [
        'departamento',
        'user_id'
        
    ];
    protected $allowedSorts = [
        'departamento',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }
}
