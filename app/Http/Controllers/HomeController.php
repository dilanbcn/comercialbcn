<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteComunicacion;
use App\Models\TipoCliente;
use App\Models\TipoComunicacion;
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
        $hoy = Carbon::today();
        $active = 'dashboard';
        if ($user->rol_id == 4) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion', 'clienteContactos'])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->whereHas('user', function ($sql) use ($user) {
                return $sql->where(['id_prospector' => $user->id]);
            })->with(['clienteComunicacion', 'clienteContactos'])->get();
        }
        $tipoComunicaciones = TipoComunicacion::where(['activo' => 1])->get();

        $comunicaciones = ClienteComunicacion::with(['cliente'])->whereNotNull('fecha_reunion')->orderBy('fecha_contacto', 'DESC')->take(8)->get();

        $user->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Calendario Reuniones', 'ruta' => null]]);


        return view('pages.cliente_calendario.index', compact('clientes', 'hoy', 'tipoComunicaciones', 'comunicaciones', 'active'));
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
            
            $total = $arrdata['totalGral'];
            $item->efectividad = ($total > 0) ? round((($arrdata['clientes'] / $total) * 100), 1) : 0;
            $item->width_efectividad = 'width: ' . $item->efectividad . '%';
            $item->efect_color = ($item->efectividad < 33) ? 'bg-danger' : (($item->efectividad > 33 && $item->efectividad < 66) ? 'bg-warning' : 'bg-success');

            if ($item->fecha_ingreso) {
                $inicio = Carbon::createFromDate($item->fecha_ingreso);
                $now = Carbon::now();
                $item->meses = $inicio->diffInMonths($now);
            }else {
                $item->meses = '';
            }

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
        $arrTipoCliente = array('Prospecto' => 0);
        $totClientes = 0;
        foreach ($grupoTipo as $key => $cliente) {
            $tipoCliente = TipoCliente::find($key);
            $arrTipoCliente[$tipoCliente->nombre] = count($cliente);
            $totClientes += count($cliente);
        }

        $arrData['tipo'] = $arrTipoCliente;
        
        
        // $totClientes =  (property_exists((object)$arrData, 'Cliente')) ? $arrData['tipo']['Cliente'] : 0;


        $cerrados = Cliente::whereHas('proyecto')->with('proyecto', function ($sql) {
            return $sql->whereYear('fecha_cierre', '=', date('Y'));
        })->get();

        $cerrados->map(function ($cerrados) {
            $cerrados->proyecto->map(function ($proyectos) use ($cerrados) {

                $cerrados->sum_facturas += $proyectos->proyectoFacturas->monto_venta;
            });
        });

        $totFact = $cerrados->sum('sum_facturas');

        $activos = Cliente::where(['activo' => 1])->get();
        $totalAct = $activos->count();

        $prospDisp = Cliente::where(['tipo_cliente_id' => 1])->whereNull('destino_user_id')->with(['tipoCliente', 'user', 'destino'])->count();

        
        $eficiencia = ($arrEfect->sum() > 0) ? ($totClientes/$arrEfect->sum())*100 : 0;
        // dd($totClientes, $arrEfect);
        // $sumaTotal = (property_exists((object)$arrData, 'Cliente') && property_exists((object)$arrData, 'Prospecto')) ? $arrData['tipo']['Prospecto'] + $arrData['tipo']['Cliente'] : 0;
        // $totalClientes = (property_exists((object)$arrData, 'Cliente') ) ? $arrData['tipo']['Cliente'] : 0;
        // $eficiencia =  ($totalClientes > 0) ? ( $totalClientes * 100 ) / ( $sumaTotal ) : 0;

        return view('pages.dashboard-comercial', compact('users', 'arrData', 'totFact', 'totalAct', 'totClientes', 'eficiencia', 'prospDisp'));
    }
}
