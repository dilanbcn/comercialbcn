<?php

use App\Models\DetalleVenta;
use App\Models\TipoPrecio;
use App\Models\Venta;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(DetalleVenta::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained(Venta::tabla);
            $table->integer('orden')->nullable();
            $table->boolean('mostrar_cantidad')->default(false);
            $table->integer('desde')->nullable();
            $table->integer('hasta')->nullable();
            $table->decimal('valor_implementacion', 11, 2)->nullable();
            $table->decimal('valor_mantencion', 11, 2)->nullable();
            $table->string('tipo_precio')->nullable();
            $table->string('descripcion_tipo_precio')->nullable();
            $table->decimal('precio', 11, 2)->nullable();
            $table->decimal('precio_minimo', 11, 2)->nullable();
            $table->decimal('precio_maximo', 11, 2)->nullable();

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
        Schema::dropIfExists(DetalleVenta::tabla);
    }
}
