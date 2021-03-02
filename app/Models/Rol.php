<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rol extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'com_roles';
    protected $table = Rol::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function users()
    {
    	return $this->hasMany(User::class);
    }
}
