<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoFactura extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'estado_facturas';
    protected $table = EstadoFactura::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function proyectoFactura()
    {
    	return $this->hasMany(ProyectoFactura::class);
    }

}
