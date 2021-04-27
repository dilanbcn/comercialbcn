<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComercialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $hoy = Carbon::now();
        $limite = $hoy->subMonths(8);
        $user = auth()->user();

        $clientes = Cliente::with(['tipoCliente', 'user'])->withCount(['proyecto'])->get();

        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->meses($clientes);
        });


        $groupCliente = $clientes->groupBy('activo');
        $arrEstados = array(0 => 'Inactivos', 1 => 'Activos');
        $arrGrupo = array('Activos' => 0, 'Inactivos' => 0);

        foreach ($groupCliente as $key => $cliente) {
            $arrGrupo[$arrEstados[$key]] = count($cliente);
        }

        $grupoTipo =  Cliente::orderBy('tipo_cliente_id')->get()->groupBy('tipo_cliente_id');
        $arrTipoCliente = array();
        foreach ($grupoTipo as $key => $cliente) {
            $tipoCliente = TipoCliente::find($key);
            $arrTipoCliente[$tipoCliente->nombre] = count($cliente);
        }

        $arrEstado = array(0 => 'Inactivo', 1 => 'Activo');

        $grupoEstado = Cliente::where(['tipo_cliente_id' => 2])->orderBy('tipo_cliente_id')->get()->groupBy('activo');
        $arrEstadoCliente = array();
        foreach ($grupoEstado as $key => $cliente) {
            $arrEstadoCliente[$arrEstado[$key]] = count($cliente);
        }

        // COMERCIALES
        $comerciales = User::where(['activo' => 1])->whereIn('rol_id', [1, 2])->count();
        $arrData['comerciales'] = array('activo' => $comerciales);

        // TOP COMERCIALES
        $comerciales = User::where(['activo' => 1])->whereIn('rol_id', [1, 2])->take(8)->get();
        foreach ($comerciales as $comercial) {
            $arrTop['nombres'][] = $comercial->name;

            $topComerciales = Cliente::where(['user_id' => $comercial->id])->get()->groupBy('tipo_cliente_id');
            $arrClienteCom = array();
            if (count($topComerciales) > 0) {
                foreach ($topComerciales as $key => $topCom) {
                    $tipoCliente = TipoCliente::find($key);
                    $arrTop[$tipoCliente->nombre][] = count($topCom);
                }
            } else {
                $arrTop['Cliente'][] = 0;
                $arrTop['Prospecto'][] = 0;
            }
        }

        $arrData['grafico'] = $arrTop;
        $arrData['tipo'] = $arrTipoCliente;
        $arrData['estado'] = $arrEstadoCliente;

        return view('pages.comerciales.indicadores', compact('clientes', 'arrGrupo', 'arrData'));
    }
}
