<?php

namespace App\Http\Controllers;

use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function meses($clientes)
    {
        return Carbon::now()->diffInMonths($clientes->inicio_ciclo);
    }

    public function makeClient($cliente)
    {
        $esCliente = Proyecto::where(['cliente_id' => $cliente->id])->first();

        if ($esCliente && $cliente->tipo_cliente_id == 1) {
            $cliente->tipo_cliente_id = 2;
            $cliente->save();
        }
    }

    public function decimalFormatBD($decimal)
    {
        $sinPuntos = str_replace('.', '', $decimal);
        $numberDB = str_replace(',', '.', $sinPuntos);

        return $numberDB;
    }

    public function decimalFormat($numberDb)
    {
        return number_format($numberDb, 2, ',', '.');
    }
}
