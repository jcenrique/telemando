<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogMessage extends Model
{
  

    protected $table ='log_messages';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'level',
        'level_name',
        'message',
        'logged_at',
      
    ];
}
