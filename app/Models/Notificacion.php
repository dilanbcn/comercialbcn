<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificacion extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'notificaciones';
    protected $table = Notificacion::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'origen_user_id',
        'cliente_id',
        'tipo_notificacion_id',
        'contenido',
        'lectura'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function origen()
    {
    	return $this->belongsTo(User::class, 'origen_user_id', 'id');
    }

    public function cliente()
    {
    	return $this->belongsTo(Cliente::class);
    }

    public function tipoNotificacion()
    {
    	return $this->belongsTo(TipoNotificacion::class);
    }

    

    

    

}
