<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Builder;


class Marcavehiculo extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='marcavehiculos';

    protected $fillable = [
        'marca',
        
    ];
    protected $allowedSorts = [
        'marca',
        'created_at',
        'updated_at'
    ];

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
           
            $builder->orderBy('marca', 'asc');
        });
    }
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    public function modelos()
    {
       return $this->hasMany(Modelovehiculo::class);
    }
    public function scopeOrdered(Builder  $query)
    {
      
        return $query->orderBy('marca')->get();
    }
   
}
