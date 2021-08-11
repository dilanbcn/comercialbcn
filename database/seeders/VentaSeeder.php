<?php

namespace Database\Seeders;

use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class VentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Venta::flushEventListeners();

        $archivo = File::get(storage_path('seeders/venta.json'));
        $ventas = json_decode($archivo, true); 

        foreach($ventas as $venta) {
            DB::table(Venta::tabla)->insert([
                'tipo_venta_id' => $venta['tipo_venta_id'],
                'nombre' => $venta['nombre'],
                'descripcion_extra' => $venta['descripcion_extra'],
                'mostrar_extra' => $venta['mostrar_extra'],
                'precio_extra' => $venta['precio_extra'],
                'multiplicar' => $venta['multiplicar'],
                'valor_multiplicar' => $venta['valor_multiplicar'],
                'mostrar_precio_base' => $venta['mostrar_precio_base'],
                'precio_base' => $venta['precio_base'],
                'estado' => $venta['estado'],
                'excluyente' => $venta['excluyente'],
                'observaciones' => $venta['observaciones'],
                'created_at' => Carbon::now()
            ]);
        }
    }
}
