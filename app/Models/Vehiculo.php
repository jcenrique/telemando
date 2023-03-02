<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Vehiculo extends Model
{
    use HasFactory;
    use AsSource, Filterable;

    
    protected $table ='vehiculos';

    protected $fillable = [
        'matricula',
        'tipovehiculo_id',
        'marcavehiculo_id',
        'modelovehiculo_id',
        'departamento_id',
        'tecnologia_id',
        'detalletecnologia_id',
        'kilometraje_inicial',
        'fecha_matriculacion', 
        'observacion',
        'fecha_baja',
        'regimen',
        
    ];
    protected $allowedSorts = [
        'matricula',
        'tipovehiculo_id',
        'marcavehiculo_id',
        'modelovehiculo_id',
        'departamento_id',
        'tecnologia_id',
        'detalletecnologia_id',
        'kilometraje_inicial',
        'fecha_matriculacion', 
        'observacion',
        'fecha_baja',
        'regimen',
        'created_at',
        'updated_at'
    ];
    protected $allowedFilters = [
        'matricula',
        'tipovehiculo_id',
        'marcavehiculo_id',
        'modelovehiculo_id',
        'departamento_id',
        'tecnologia_id',
        'fecha_matriculacion',
        'regimen',
    ];

    public function tipovehiculo()
    {
        $this->hasOne(Tipovehiculo::class);

    }
    public function modelovehiculo()
    {
        $this->hasOne(Modelovehiculo::class);
        
    }
    public function marcavehiculo()
    {
        $this->hasOne(Marcavehiculo::class);
        
    }
    public function departamento()
    {
        $this->hasOne(Departamento::class);
        
    }
    public function tecnologia()
    {
        $this->hasOne(Tecnologia::class);
        
    }
    public function detalletecnologia()
    {
        $this->hasOne(Detalletecnologia::class);
        
    }

    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }

    public function kilometrajes()
    {
        return $this->hasMany(Kilometraje::class)->orderByDesc('fecha');
    }
}
