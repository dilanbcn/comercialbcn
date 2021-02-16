<?php

use App\Models\Producto;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Producto::tabla, function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(User::tabla);
            $table->string('nombre');
            $table->string('archivo');
            $table->string('ruta');
            $table->string('extension');
            $table->string('icono');

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
        Schema::dropIfExists(Producto::tabla);
    }
}
