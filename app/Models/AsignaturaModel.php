<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaturaModel extends Model
{
    use HasFactory;

    protected $table = 'asignaturas';
    protected $primaryKey = 'id';
    protected $hidden = ['id'];
    protected $casts = [
        'estudiantes' => 'array'
    ];
    
    public $timestamps = false;
    public $fillable = [
        'profesor_id',
        'nombre',
        'descripcion',
        'creditos',
        'areaConocimiento',
        'tipo',
        'estudiantes',
        'actualizado'
    ];
}
