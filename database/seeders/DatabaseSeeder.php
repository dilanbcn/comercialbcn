<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // RolesTableSeeder::class,
            // UsersTableSeeder::class,
            // TipoClienteTableSeeder::class,
            // EstadoFacturasTableSeeder::class,
            // ClienteTableSeeder::class,
            // ProyectosTableSeeder::class,
            // ProyectoFacturasTableSeeder::class,
            // // TipoComunicacionTableSeeder::class,
            // // TipoNotificacionesTableSeeder::class,
            TipoVentaSeeder::class,
            VentaSeeder::class,
            DetalleVentaSeeder::class
        ]);
    }
}
