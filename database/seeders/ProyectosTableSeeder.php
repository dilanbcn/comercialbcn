<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProyectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Proyecto::flushEventListeners();

        $archivo = File::get(storage_path('seeders/proyectos.json'));
        $proyectos = json_decode($archivo, true);

        foreach($proyectos as $proyecto) {
            DB::table(Proyecto::tabla)->insert([
                'cliente_id' => $proyecto['cliente_id'],
                'nombre' => $proyecto['nombre'],
                'fecha_cierre' => date('Y-m-d', strtotime($proyecto['fecha_cierre'])),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
