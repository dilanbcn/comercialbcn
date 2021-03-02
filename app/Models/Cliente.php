<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'com_clientes';
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
        'cantidad_empleados',
        'rubro',
        'inicio_ciclo',
        'inicio_relacion',
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

    public function proyecto()
    {
        return $this->hasMany(Proyecto::class);
    }

    public function clienteContactos()
    {
        return $this->hasMany(ClienteContacto::class);
    }

    public function clienteComunicacion()
    {
        return $this->hasMany(ClienteComunicacion::class);
    }

}
