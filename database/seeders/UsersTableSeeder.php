<?php
namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::flushEventListeners();

        $archivo = File::get(storage_path('seeders/usuarios.json'));
        $usuarios = json_decode($archivo, true); 

        foreach ($usuarios  as $usuario) {

            DB::table(User::tabla)->insert([
                'rol_id' => $usuario['rol_id'],
                'id_prospector' => $usuario['id_prospector'],
                'username' => $usuario['username'],
                'id_number' => $usuario['id_number'],
                'name' => mb_convert_case(mb_strtolower($usuario['name'],'utf-8'), MB_CASE_TITLE),
                'last_name' => mb_convert_case(mb_strtolower($usuario['last_name'],'utf-8'), MB_CASE_TITLE),
                'email' => strtolower($usuario['email']),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('secret'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
