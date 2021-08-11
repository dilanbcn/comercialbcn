<?php

namespace Database\Seeders;

use App\Models\DetalleVenta;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DetalleVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DetalleVenta::flushEventListeners();

        $archivo = File::get(storage_path('seeders/detalle_venta.json'));
        $detalleVentas = json_decode($archivo, true); 

        foreach($detalleVentas as $tipo) {
            DB::table(DetalleVenta::tabla)->insert([
                'venta_id' => $tipo['venta_id'],
                'orden' => $tipo['orden'],
                'mostrar_cantidad' => $tipo['mostrar_cantidad'],
                'desde' => $tipo['desde'],
                'hasta' => $tipo['hasta'],
                'valor_implementacion' => $tipo['valor_implementacion'],
                'valor_mantencion' => $tipo['valor_mantencion'],
                'tipo_precio' => $tipo['tipo_precio'],
                'descripcion_tipo_precio' => $tipo['descripcion_tipo_precio'],
                'precio' => $tipo['precio'],
                'precio_minimo' => $tipo['precio_minimo'],
                'precio_maximo' => $tipo['precio_maximo'],
                'created_at' => Carbon::now()
            ]);
        }
    }
}
