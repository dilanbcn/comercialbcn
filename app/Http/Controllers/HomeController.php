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
        $clientes = Cliente::where(['activo' => 1])->orderBy('tipo_cliente_id')->get();

        $grupoTipo = $clientes->groupBy('tipo_cliente_id');
        $arrTipoCliente = array();
        foreach ($grupoTipo as $key => $cliente) {
            $tipoCliente = TipoCliente::find($key);
            $arrTipoCliente[$tipoCliente->nombre] = count($cliente);
        }


        $grupoEstado = $clientes->groupBy('activo');
        $arrEstadoCliente = array();
        $arrEstado = array(0 => 'Inactivo', 1 => 'Activo');
        foreach ($grupoEstado as $key => $cliente) {
            $arrEstadoCliente[$arrEstado[$key]] = count($cliente);
        }

        // COMERCIALES
        $comerciales = User::where(['activo' => 1])->count();

        $arrData['tipo'] = $arrTipoCliente;
        $arrData['estado'] = $arrEstadoCliente;
        $arrData['comerciales'] = array('activo' => $comerciales);


        return view('pages.dashboard', compact('arrData'));
    }
}
