<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'perfiles';
    protected $table = Perfil::tabla;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'menu_id',
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
