<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'ventas';
    protected $table = Venta::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tipo_venta_id',
        'nombre',
        'descripcion_extra',
        'mostrar_extra',
        'precio_extra',
        'multiplicar',
        'valor_multiplicar',
        'mostrar_precio_base',
        'precio_base',
        'estado',
        'excluyente',
        'observaciones'
    ];

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class);
    }

    public function tipoVenta()
    {
        return $this->belongsTo(TipoVenta::class);
    }
}
