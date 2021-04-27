<?php

use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Proyecto::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained(Cliente::tabla);
            $table->string('nombre');
            $table->date('fecha_cierre');
            $table->integer('updated_by')->nullable();
            
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
        Schema::dropIfExists(Proyecto::tabla);
    }
}
