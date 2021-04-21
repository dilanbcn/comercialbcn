<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoNotificacion extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'tipo_notificacion';
    protected $table = TipoNotificacion::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'descripcion',
        'badge',
        'activo',
    ];

    public function notificacion()
    {
    	return $this->hasMany(Notificacion::class);
    }
}
