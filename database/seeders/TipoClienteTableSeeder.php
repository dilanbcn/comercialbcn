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
        $tipos = json_decode($archivo, true); 

        foreach($tipos as $tipo) {
            DB::table(TipoCliente::tabla)->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'badge' => $tipo['badge'],
                'activo' => $tipo['activo'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
