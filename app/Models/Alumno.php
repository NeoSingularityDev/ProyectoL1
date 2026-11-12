<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [
        'matricula',
        'nombre',
        'apellido',
        'age',
        'email',
        'activo'
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
            'activo' => 'boolean'
        ];
    }
}
