<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVenta extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'detalle_ventas';
    protected $table = DetalleVenta::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'venta_id',
        'orden',
        'mostrar_cantidad',
        'desde',
        'hasta',
        'valor_implementacion',
        'valor_mantencion',
        'tipo_precio',
        'descripcion_tipo_precio',
        'precio',
        'precio_minimo',
        'precio_maximo',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
