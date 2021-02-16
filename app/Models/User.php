<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const tabla = 'users';
    protected $table = User::tabla;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rol_id',
        'username',
        'id_number',
        'name',
        'last_name',
        'email',
        'activo',
        'id_prospector'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }

    public function cliente()
    {
        return $this->hasMany(Cliente::class);
    }

    public function prospector()
    {
        return $this->belongsTo(User::class, 'id_prospector', 'id');
    }

    public function comunicacionProspector()
    {
        return $this->hasMany(ClienteComunicacion::class, 'prospector_id', 'id');
    }

    public function comunicacionComercial()
    {
        return $this->hasMany(ClienteComunicacion::class, 'comercial_id', 'id');
    }

    public function producto()
    {
        return $this->hasMany(Producto::class);
    }

    public static function createPass($long = 8)
    {
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $password = "";
        for ($i = 0; $i < $long; $i++) {
            $password .= substr($str, rand(0, 62), 1);
        }

        return $password;
    }
}
