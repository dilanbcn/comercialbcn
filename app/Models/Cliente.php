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
        'destino_user_id',
        'holding',
        'tipo_cliente_id',
        'compartido_user_id',
        'externo',
        'rut',
        'razon_social',
        'direccion',
        'telefono',
        'email',
        'activo',
        'fue_cliente',
        'actividad',
        'cantidad_empleados',
        'rubro',
        'inicio_ciclo',
        'inicio_relacion',
        'updated_by'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function destino()
    {
    	return $this->belongsTo(User::class, 'destino_user_id', 'id');
    }

    public function compartido()
    {
    	return $this->belongsTo(User::class, 'compartido_user_id', 'id');
    }

    public function tipoCliente()
    {
    	return $this->belongsTo(TipoCliente::class);
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

    public function notificacion()
    {
    	return $this->hasMany(Notificacion::class);
    }

}
