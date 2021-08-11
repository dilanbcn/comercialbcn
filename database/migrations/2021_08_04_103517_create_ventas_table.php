<?php

use App\Models\TipoVenta;
use App\Models\Venta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Venta::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_venta_id')->constrained(TipoVenta::tabla);
            $table->string('nombre');
            $table->string('descripcion_extra')->nullable();
            $table->decimal('precio_extra', 11, 2)->nullable();
            $table->boolean('mostrar_extra')->default(false);
            $table->boolean('multiplicar')->default(false);
            $table->boolean('valor_multiplicar')->default(false);
            $table->decimal('precio_base', 11, 2)->nullable();
            $table->boolean('mostrar_precio_base')->default(false);
            $table->boolean('estado')->default(true);
            $table->boolean('excluyente')->default(false);
            $table->boolean('observaciones')->default(false);

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
        Schema::dropIfExists(Venta::tabla);
    }
}
