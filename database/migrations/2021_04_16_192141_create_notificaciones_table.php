<?php

use App\Models\Cliente;
use App\Models\Notificacion;
use App\Models\TipoNotificacion;
use App\Models\TipoNotificaciones;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Notificacion::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(User::tabla);
            $table->integer('origen_user_id')->unsigned()->nullable();
            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreignId('tipo_notificacion_id')->constrained(TipoNotificacion::tabla);
            $table->longText('contenido');
            $table->boolean('lectura');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Notificacion::tabla);
    }
}
