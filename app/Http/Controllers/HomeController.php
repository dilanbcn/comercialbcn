<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\User;
use Carbon\Carbon;

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
    public function indexProspector()
    {
        $user = auth()->user();

        // if ($user->rol_id == 2) {
        
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

            return view('pages.dashboard-prospector', compact('arrData'));

        // } else {

        //     return redirect()->route('cliente.index')->with(['status' => 'No tiene acceso a esa vista', 'title' => 'Error', 'estilo' => 'error']);
            
        // }
    }

    public function indexComercial()
    {

        $hoy = Carbon::now();
        $limite = $hoy->subMonths(8);
        $user = auth()->user();

        if ($user->rol_id == 1) {
            $clientes = Cliente::where(['user_id' => $user->id])->with(['tipoCliente', 'padre', 'user'])->withCount(['proyecto'])->get();
        } else {
            $clientes = Cliente::with(['tipoCliente', 'padre', 'user'])->withCount(['proyecto'])->get();
        }

        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->meses($clientes);
        });


        $groupCliente = $clientes->groupBy('activo');
        $arrEstados = array(0 => 'Inactivos', 1 => 'Activos');
        $arrGrupo = array('Activos' => 0, 'Inactivos' => 0);

        foreach ($groupCliente as $key => $cliente) {
            $arrGrupo[$arrEstados[$key]] = count($cliente);
        }

        return view('pages.dashboard-comercial', compact('clientes', 'arrGrupo'));
    }
}
