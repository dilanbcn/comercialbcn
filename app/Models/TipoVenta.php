<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoVenta extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'tipo_ventas';
    protected $table = TipoVenta::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function venta() {
        return $this->hasMany(Venta::class);
    }
}
