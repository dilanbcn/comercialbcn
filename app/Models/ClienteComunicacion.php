<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteComunicacion extends Model
{
    use HasFactory;

    use HasFactory, SoftDeletes;

    const CORREO = 1;
    const LLAMADA = 2;

    const tabla = 'cliente_comunicaciones';
    protected $table = ClienteComunicacion::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cliente_id',
        'cliente_contacto_id',
        'tipo_comunicacion_id',
        'nombre_contacto',
        'apellido_contacto',
        'cargo_contacto',
        'correo_contacto',
        'telefono_contacto',
        'celular_contacto',
        'comercial_nombre',
        'fecha_contacto',
        'linkedin',
        'envia_correo',
        'respuesta',
        'observaciones',
        'fecha_reunion',
        'reunion_valida',
        'fecha_validacion',
        'usuario_validacion',
        'usuario_validacion_nombre'

    ];

    public function cliente()
    {
    	return $this->belongsTo(Cliente::class);
    }

    public function clienteContacto()
    {
    	return $this->belongsTo(ClienteContacto::class);
    }

    public function tipoComunicacion()
    {
    	return $this->belongsTo(TipoComunicacion::class);
    }
}
