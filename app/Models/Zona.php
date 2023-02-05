<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Zona extends Model
{
    use HasFactory;

    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'zona',



    ];
    protected $allowedSorts = [
        'zona',
        'created_at',
        'updated_at'
    ];

    public function ubicaciones()
    {
        return $this->belongsTo(Ubicacion::class);
    }

}
