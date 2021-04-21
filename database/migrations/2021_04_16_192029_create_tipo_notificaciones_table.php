<?php

use App\Models\TipoNotificacion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TipoNotificacion::tabla, function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('badge')->nullable();
            $table->boolean('activo')->default(true);

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
        Schema::dropIfExists(TipoNotificacion::tabla);
    }
}
