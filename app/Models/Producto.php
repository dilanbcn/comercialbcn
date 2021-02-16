<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'productos';
    protected $table = Producto::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'nombre',
        'archivo',
        'ruta',
        'icono',
        'extension',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
