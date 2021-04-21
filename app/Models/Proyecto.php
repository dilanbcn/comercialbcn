<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'proyectos';
    protected $table = Proyecto::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cliente_id',
        'fecha_cierre',
        'nombre',
    ];

    public function cliente()
    {
    	return $this->belongsTo(Cliente::class);
    }

    public function proyectoFacturas()
    {
    	return $this->hasOne(ProyectoFactura::class);
    }

}
