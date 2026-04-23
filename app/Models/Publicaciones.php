<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publicaciones extends Model
{
    protected $table = 'publicaciones';

    protected $fillable = [
        'titulo',
        'contenido',
        'email_registro',
        'imagen',
        'fecha_registro'
    ];

    public $timestamps = false;
}