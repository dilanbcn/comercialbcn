<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {

        // CLIENTES
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
        $comerciales = User::where(['activo' => 1])->count();
        $arrData['comerciales'] = array('activo' => $comerciales);

        // TOP COMERCIALES
        $comerciales = User::where(['activo' => 1])->take(8)->get();
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

        // $topComerciales = Cliente::get()->groupBy('user_id');
        // $arrTopCom = array();
        // $arrEstado = array(0 => 'Inactivo', 1 => 'Activo');
        // foreach ($topComerciales as $key => $top) {
        //     $comercial = User::find($key);
        //     $arrTopCom[$comercial->name]['total'] = count($top);
        //     $arrTopCom[$comercial->name]['Activo'] = 0;
        //     $arrTopCom[$comercial->name]['Inactivo'] = 0;
        //     $arrTopCom[$comercial->name]['Prospecto'] = 0;
        //     $arrTopCom[$comercial->name]['Cliente'] = 0;

            

        //     foreach ($top as $cliente) { 
        //         $tipoCliente = TipoCliente::find($cliente->tipo_cliente_id);
        //         $arrTopCom[$comercial->name][$arrEstado[$cliente->activo]] += 1;
        //         $arrTopCom[$comercial->name][$tipoCliente->nombre] += 1;
        //         // echo $arrEstado[$cliente->activo]."<br>";
        //     }

        // }

        // dd($arrData);


        return view('pages.dashboard', compact('arrData'));
    }
}
