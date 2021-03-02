<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteContacto extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'com_cliente_contacto';
    protected $table = ClienteContacto::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cliente_id',
        'nombre',
        'apellido',
        'cargo',
        'correo',
        'telefono',
        'celular',
        'activo',
    ];

    public function cliente()
    {
    	return $this->belongsTo(Cliente::class);
    }

    public function clienteComunicacion()
    {
    	return $this->hasMany(ClienteComunicacion::class);
    }

}
