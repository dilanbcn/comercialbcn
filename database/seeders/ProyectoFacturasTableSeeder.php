<?php

namespace Database\Seeders;

use App\Models\ProyectoFactura;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProyectoFacturasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProyectoFactura::flushEventListeners();

        $archivo = File::get(storage_path('seeders/facturas.json'));
        $facturas = json_decode($archivo, true);

        foreach($facturas as $factura) {
            DB::table(ProyectoFactura::tabla)->insert([
                'proyecto_id' => $factura['proyecto_id'],
                'estado_factura_id' => $factura['estado_factura_id'],
                'fecha_factura' => date('Y-m-d', strtotime($factura['fecha_factura'])),
                // 'fecha_pago' => date('Y-m-d', strtotime($factura['fecha_pago'])),
                'monto_venta' => $factura['monto_venta'],
                'inscripcion_sence' => $factura['inscripcion_sence'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
