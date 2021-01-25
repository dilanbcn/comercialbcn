<?php

namespace Database\Seeders;

use App\Models\TipoCliente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TipoClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TipoCliente::flushEventListeners();

        $archivo = File::get(storage_path('seeders/tipo_cliente.json'));
        $roles = json_decode($archivo, true); 

        foreach($roles as $rol) {
            DB::table(TipoCliente::tabla)->insert([
                'nombre' => $rol['nombre'],
                'descripcion' => $rol['descripcion'],
                'activo' => $rol['activo'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
