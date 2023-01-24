<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorModel extends Model
{
    use HasFactory;

    protected $table = 'profesores';
    protected $primaryKey = 'id';
    protected $hidden = ['id'];
    
    public $timestamps = false;
    public $fillable = [
        'documento',
        'nombre',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'creado',
        'actualizado'
    ];
}
