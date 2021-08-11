<?php

namespace Database\Seeders;

use App\Models\TipoVenta;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TipoVentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoVenta::flushEventListeners();

        $archivo = File::get(storage_path('seeders/tipo_venta.json'));
        $tipoVentas = json_decode($archivo, true); 

        foreach($tipoVentas as $tipo) {
            DB::table(TipoVenta::tabla)->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'created_at' => Carbon::now()
            ]);
        }
    }
}
