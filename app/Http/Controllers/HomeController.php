<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $usuarios = User::where(['activo' => 1])->whereIn('rol_id', [1, 2])->get();
        $user = auth()->user();
        $users = $usuarios->map(function ($item) {
            $arrdata = $this->getEstadoClientes($item);
            $item->activos = $arrdata['activo'];
            $item->inactivos = $arrdata['inactivo'];
            $item->prospectos = $arrdata['prospectos'];
            $item->total_general = $arrdata['totalGral'];
            $item->clientes = $arrdata['clientes'];
            $pctActivos = ($arrdata['clientes'] > 0 && $arrdata['totalGral'] > 0) ? round((($arrdata['clientes'] / $arrdata['totalGral']) * 100), 1) : 0;
            // $pctActivos = ($arrdata['clientes'] > 0) ? round((($arrdata['activo'] / $arrdata['clientes']) * 100), 1) : 0;
            $item->pct_activos = $pctActivos;
            $item->pct_inactivos = ($arrdata['clientes'] > 0 && $arrdata['totalGral'] > 0) ? 100 - $pctActivos : 0;
            
            $total = $arrdata['prospectos'] + $arrdata['clientes'];
            $item->efectividad = ($total > 0) ? round((($arrdata['clientes'] / $total) * 100), 1) : 0;
            $item->width_efectividad = 'width: ' . $item->efectividad . '%';
            $item->efect_color = ($item->efectividad < 33) ? 'bg-danger' : (($item->efectividad > 33 && $item->efectividad < 66) ? 'bg-warning' : 'bg-success');
            return $item;
        });

        $suma = 0;
        $arrEfect = 0;
        $arrEfect = $usuarios->map(function ($item) use ($suma) {
            $arrdata = $this->getEstadoClientes($item);
            $pctActivos = ($arrdata['clientes'] > 0) ? round((($arrdata['activo'] / $arrdata['clientes']) * 100), 1) : 0;
            $total = $arrdata['prospectos'] + $arrdata['clientes'];
            
            $suma += ($total * $pctActivos);
            
            return $suma;
        });

        $grupoTipo =  Cliente::orderBy('tipo_cliente_id')->get()->groupBy('tipo_cliente_id');
        $arrTipoCliente = array();
        $totClientes = 0;
        foreach ($grupoTipo as $key => $cliente) {
            $tipoCliente = TipoCliente::find($key);
            $arrTipoCliente[$tipoCliente->nombre] = count($cliente);
            $totClientes += count($cliente);
        }

        $arrData['tipo'] = $arrTipoCliente;


        $cerrados = Cliente::whereHas('proyecto')->with('proyecto', function ($sql) {
            return $sql->with('proyectoFacturas', function($sql){
                return $sql->whereMonth('fecha_factura', '=', date('m'))->whereYear('fecha_factura', '=', date('Y'));
            });
        })->get();

        $cerrados->map(function ($cerrados) {
            $cerrados->proyecto->map(function ($proyectos) use ($cerrados) {

                $cerrados->sum_facturas = $proyectos->proyectoFacturas->sum('monto_venta');
            });
        });

        $totFact = $cerrados->sum('sum_facturas');

        $activos = Cliente::where(['activo' => 1])->get();
        $totalAct = $activos->count();
        $eficiencia = ($totClientes/$arrEfect->sum())*100;

        return view('pages.dashboard-comercial', compact('users', 'arrData', 'totFact', 'totalAct', 'totClientes', 'eficiencia'));
    }
}
