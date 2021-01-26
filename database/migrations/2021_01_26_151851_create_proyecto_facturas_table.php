<?php

use App\Models\EstadoFactura;
use App\Models\FacturaSence;
use App\Models\Proyecto;
use App\Models\ProyectoFactura;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectoFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ProyectoFactura::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained(Proyecto::tabla);
            $table->foreignId('estado_factura_id')->constrained(EstadoFactura::tabla);
            $table->date('fecha_factura')->nullable();
            $table->date('fecha_pago')->nullable();
            $table->decimal('monto_venta', 22, 2);
            $table->string('inscripcion_sence');
            
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
        Schema::dropIfExists(ProyectoFactura::tabla);
    }
}
