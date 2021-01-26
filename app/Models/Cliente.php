<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'clientes';
    protected $table = Cliente::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'padre_id',
        'tipo_cliente_id',
        'rut',
        'razon_social',
        'direccion',
        'telefono',
        'email',
        'activo',
        'inicio_ciclo'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function tipoCliente()
    {
    	return $this->belongsTo(TipoCliente::class);
    }

    public function padre()
    {
        return $this->belongsTo(Cliente::class, 'padre_id', 'id');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class);
    }

}
