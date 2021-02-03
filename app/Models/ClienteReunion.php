<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClienteReunion extends Model
{
    use HasFactory, SoftDeletes;

    const tabla = 'cliente_reuniones';
    protected $table = ClienteReunion::tabla;

    protected $dates = ['deleted_at'];

}
