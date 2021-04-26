<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ClienteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::flushEventListeners();

        $archivo = File::get(storage_path('seeders/clientes.json'));
        $clientes = json_decode($archivo, true);

        foreach($clientes as $cliente) {
            DB::table(Cliente::tabla)->insert([
                'user_id' => $cliente['user_id'],
                'destino_user_id' => $cliente['user_id'],
                'razon_social' => $cliente['razon_social'],
                'tipo_cliente_id' => $cliente['tipo_cliente_id'],
                'holding' => $cliente['holding'],
                'inicio_ciclo' => ($cliente['inicio_ciclo'] != '') ? $cliente['inicio_ciclo'] : null,
                'inicio_relacion' => ($cliente['inicio_relacion'] != '') ? $cliente['inicio_relacion'] : null,
                'activo' => $cliente['activo'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
