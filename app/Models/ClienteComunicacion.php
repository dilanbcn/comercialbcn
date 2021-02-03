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
        'tipo_comunicacion',
        'comercial_nombre',
        'fecha_contacto',
        'linkedin',
        'envia_correo',
        'respuesta',
        'fecha_reunion',
        'reunion_valida',
        'observaciones',
    ];

    public function cliente()
    {
    	return $this->belongsTo(Cliente::class);
    }
}
