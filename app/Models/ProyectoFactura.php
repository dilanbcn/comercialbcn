<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProyectoFactura extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'com_proyecto_facturas';
    protected $table = ProyectoFactura::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'proyecto_id',
        'estado_factura_id',
        'inscripcion_sence',
        'fecha_factura',
        'fecha_pago',
        'monto_venta',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function estadoFactura()
    {
        return $this->belongsTo(EstadoFactura::class);
    }

}
