<?php

namespace App\Models;

use App\Orchid\Presenters\AlarmaPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;


class Alarma extends Model
{
    use HasFactory;
    use   Searchable;
   // use AsSource, Filterable, Attachable;

    protected $fillable = [
        'alarma',
        'consecuencia',
        'actuacion',
        'origen',
        'elemento_id',
       
        
    ];

    // protected $allowedSorts = [
    //     'alarma',
    //     'consecuencia',
    //     'actuacion',
    //     'origen',
    //     'elemento_id',
    // ];


    public function elemento()
    {
        return $this->hasOne(Elemento::class);
    }

    public function toSearchableArray()
    {
        return [
          
            'alarma' => $this->alarma,
           
        ];
    }
    

    public function presenter()
    {
        return new AlarmaPresenter($this);
    }

}