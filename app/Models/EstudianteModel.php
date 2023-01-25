<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudianteModel extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';
    protected $primaryKey = 'id';
    protected $hidden = ['id'];
    protected $casts = [
        'asignaturas' => 'array'
    ];

    public $timestamps = false;
    public $fillable = [
        'documento',
        'nombre',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'semestre',
        'asignaturas',
        'creado',
        'actualizado'
    ];
}
