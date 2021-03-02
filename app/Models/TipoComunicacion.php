<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoComunicacion extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'com_tipo_comunicaciones';
    protected $table = TipoComunicacion::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];

    public function clienteComunicacion()
    {
    	return $this->hasMany(ClienteComunicacion::class);
    }
}
