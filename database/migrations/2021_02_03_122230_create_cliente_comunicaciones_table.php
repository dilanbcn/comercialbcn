<?php

use App\Models\Cliente;
use App\Models\ClienteComunicacion;
use App\Models\ClienteContacto;
use App\Models\TipoComunicacion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteComunicacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ClienteComunicacion::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained(Cliente::tabla);
            $table->foreignId('cliente_contacto_id')->constrained(ClienteContacto::tabla);
            $table->foreignId('tipo_comunicacion_id')->constrained(TipoComunicacion::tabla);
            $table->string('nombre_contacto');
            $table->string('apellido_contacto')->nullable();
            $table->string('cargo_contacto')->nullable();
            $table->string('correo_contacto')->nullable();
            $table->string('telefono_contacto')->nullable();
            $table->string('celular_contacto')->nullable();
            $table->string('comercial_id');
            $table->string('comercial_nombre');
            $table->string('prospector_id');
            $table->string('prospector_nombre');
            $table->date('fecha_contacto');
            $table->boolean('linkedin')->nullable();
            $table->boolean('envia_correo')->nullable();
            $table->boolean('respuesta')->nullable();
            $table->longText('observaciones');
            $table->dateTime('fecha_reunion')->nullable();
            $table->boolean('reunion_valida')->default(false);
            $table->dateTime('fecha_validacion')->nullable();
            $table->integer('usuario_validacion')->nullable()->unsigned();
            $table->string('usuario_validacion_nombre')->nullable();
            
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
        Schema::dropIfExists(ClienteComunicacion::tabla);
    }
}
