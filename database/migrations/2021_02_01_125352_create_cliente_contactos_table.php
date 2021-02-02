<?php

use App\Models\ClienteContacto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ClienteContacto::tabla, function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->unsigned();
            $table->string('nombre');
            $table->string('apellido')->nullable();
            $table->string('cargo')->nullable();;
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
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
        Schema::dropIfExists(ClienteContacto::tabla);
    }


}
