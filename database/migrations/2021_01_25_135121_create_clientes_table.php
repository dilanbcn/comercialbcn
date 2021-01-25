<?php

use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Cliente::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('pais_id')->constrained(User::tabla);
            $table->integer('padre_id')->unsigned()->nullable();
            $table->foreignId('tipo_cliente_id')->constrained(TipoCliente::tabla);
            $table->string('rut')->nullable();
            $table->string('razon_social');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists(Cliente::tabla);
    }
}
