<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCliente extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'com_tipo_clientes';
    protected $table = TipoCliente::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function users()
    {
    	return $this->hasMany(Cliente::class);
    }
}
