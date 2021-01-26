<?php

namespace Database\Seeders;

use App\Models\EstadoFactura;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class EstadoFacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EstadoFactura::flushEventListeners();

        $archivo = File::get(storage_path('seeders/estado_facturas.json'));
        $estados = json_decode($archivo, true); 

        foreach($estados as $estado) {
            DB::table(EstadoFactura::tabla)->insert([
                'nombre' => $estado['nombre'],
                'descripcion' => $estado['descripcion'],
                'activo' => $estado['activo'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
