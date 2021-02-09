<?php

namespace Database\Seeders;

use App\Models\TipoComunicacion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TipoComunicacionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoComunicacion::flushEventListeners();

        $archivo = File::get(storage_path('seeders/tipo_comunicacion.json'));
        $roles = json_decode($archivo, true); 

        foreach($roles as $rol) {
            DB::table(TipoComunicacion::tabla)->insert([
                'nombre' => $rol['nombre'],
                'descripcion' => $rol['descripcion'],
                'icono' => $rol['icono'],
                'activo' => $rol['activo'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
