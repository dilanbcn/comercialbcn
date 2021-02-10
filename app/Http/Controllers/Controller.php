<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Proyecto;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function meses($cliente)
    {
        return Carbon::now()->diffInMonths($cliente->inicio_ciclo);
    }

    public function antiguedad($fecha, $tipo = 'antiguo')
    {

        switch ($tipo) {
            case 'meses':
                $dM = ($fecha) ? Carbon::today()->diffInMonths($fecha) : 0;
                $return = $dM;
                break;
            default:
                $dY = ($fecha) ? Carbon::today()->diffInYears($fecha) : 0;
                $return = ($dY >= 1) ? 'Antiguo' : 'Nuevo';
                break;
        }


        return $return;
    }

    public function makeClient($cliente)
    {
        $esCliente = Proyecto::where(['cliente_id' => $cliente->id])->first();

        if ($esCliente && $cliente->tipo_cliente_id == 1) {
            $cliente->tipo_cliente_id = 2;
            $cliente->save();
        }
    }

    public function makeProspect($cliente)
    {
        $esCliente = Proyecto::where(['cliente_id' => $cliente->id])->first();

        if (!$esCliente && $cliente->tipo_cliente_id == 2) {
            $cliente->tipo_cliente_id = 1;
            $cliente->inicio_ciclo = Carbon::now();
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

    public function getEstadoClientes($user)
    {
        $arrEstado = array(0 => 'inactivo', 1 => 'activo');

        $clientes = Cliente::where(['user_id' => $user->id, 'tipo_cliente_id' => 2])->get()->groupBy('activo');
        $countProspectos = Cliente::where(['user_id' => $user->id, 'tipo_cliente_id' => 1])->count();
        $countClientes = Cliente::where(['user_id' => $user->id, 'tipo_cliente_id' => 2])->count();

        $arrEstadoCliente = array('inactivo' => 0, 'activo' => 0, 'clientes' => $countClientes, 'prospectos' => $countProspectos);
        foreach ($clientes as $key => $cliente) {
            $arrEstadoCliente[$arrEstado[$key]] = count($cliente);
        }
        return $arrEstadoCliente;
    }
}
