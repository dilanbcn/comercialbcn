<?php

namespace App\Http\Controllers;

use App\Exports\CerradosExport;
use App\Exports\ClientesGeneralExport;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use Excel;
use App\Models\Proyecto;
use App\Models\ProyectoFactura;
use App\Models\TipoCliente;
use App\Models\User;
use Carbon\Carbon;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Http\Request;
use PDF;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $comercial = null)
    {

        $hoy = Carbon::now();
        $limite = $hoy->subMonths(8);
        $user = auth()->user();
        $comercial = ($comercial) ? User::find($comercial) : null;

        $clientes = Cliente::with(['tipoCliente', 'padre', 'user'])->withCount(['proyecto'])->orderBy('razon_social')->get();

        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->meses($clientes);
        });

        $groupCliente = $clientes->groupBy('activo');
        $arrEstados = array(0 => 'Inactivos', 1 => 'Activos');
        $arrGrupo = array('Activos' => 0, 'Inactivos' => 0);

        foreach ($groupCliente as $key => $cliente) {
            $arrGrupo[$arrEstados[$key]] = count($cliente);
        }


        $user->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Clientes General', 'ruta' => null]]);

        return view('pages.cliente.index', compact('clientes', 'arrGrupo', 'comercial'));
    }

    public function allClientes()
    {
        $clientes = Cliente::with(['tipoCliente', 'padre', 'user'])->withCount(['proyecto'])->orderBy('razon_social')->get();

        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->meses($clientes);
        });

        $arrClientes = array();
        foreach ($clientes as $cliente) {
            $arrClientes[] = array(
                ($cliente->padre != null) ? $cliente->padre->razon_social : '',
                $cliente->razon_social,
                $cliente->user->name . ' ' . $cliente->user->last_name,
                $cliente->tipoCliente->nombre,
                ($cliente->tipo_cliente_id == 1) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '',
                ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '',
                ($cliente->activo) ? 'Activo' : 'Inactivo',
                $cliente->proyecto_count,
                $cliente->destino_user_id,
                $cliente->id,
            );
        }

        // <td>{{ ($cliente->padre != null) ? $cliente->padre->razon_social : '' }}</td>
        //                             <td class="text-left">{{ $cliente->razon_social }}</td>
        //                             <td class="text-left">{{ $cliente->user->name . ' ' . $cliente->user->last_name }}</td>
        //                             <td><span class="badge p-2 {{ $cliente->tipoCliente->badge }}">{{ $cliente->tipoCliente->nombre }}</span></td>
        //                             <td>{{ ($cliente->tipo_cliente_id == 1) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '' }}</td>
        //                             <td>{{ ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '' }}</td>

        $response = array('draw' => 1, 'recordsTotal' => count($arrClientes), 'recordsFiltered' => count($arrClientes), 'data' => $arrClientes);


        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prospectos()
    {
        $hoy = Carbon::now();
        $user = auth()->user();

        $user->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Prospectos Disponibles', 'ruta' => null]]);

        return view('pages.cliente.prospecto');
    }

    public function prospectosJSON()
    {

        $prospectos = Cliente::where(['tipo_cliente_id' => 1])->whereNull('destino_user_id')->with(['tipoCliente', 'padre', 'user', 'destino'])->get();

        $arrProspectos = array();
        foreach ($prospectos as $prospecto) {
            $arrProspectos[] = array(
                $prospecto->razon_social,
                $prospecto->user->name . ' ' . $prospecto->user->last_name,
                ($prospecto->destino) ? $prospecto->destino->name . ' ' . $prospecto->destino->last_name : '',
                $prospecto->id,
            );
        }


        $response = array('draw' => 1, 'recordsTotal' => count($arrProspectos), 'recordsFiltered' => count($arrProspectos), 'data' => $arrProspectos);


        return response()->json($response, 200);
    }

    public function vigencia()
    {
        $user = auth()->user();

        if ($user->rol_id == 1) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'user_id' => $user->id])->with(['tipoCliente', 'padre', 'user'])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2])->with(['tipoCliente', 'padre', 'user'])->get();
        }
        $groupCliente = $clientes->groupBy('activo');
        $arrEstados = array(0 => 'Inactivos', 1 => 'Activos');
        $arrGrupo = array('Activos' => 0, 'Inactivos' => 0);

        foreach ($groupCliente as $key => $cliente) {
            $arrGrupo[$arrEstados[$key]] = count($cliente);
        }

        $clientes->map(function ($clientes) {
            $clientes->antiguedad = $this->antiguedad($clientes->inicio_relacion);
            $clientes->vigenciaMeses = $this->antiguedad($clientes->inicio_relacion, 'meses');
        });

        $user->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Vigencia Clientes', 'ruta' => null]]);

        return view('pages.cliente.vigencia', compact('clientes', 'arrGrupo'));
    }

    public function vigenciaJSON()
    {
        $user = auth()->user();

        if ($user->rol_id == 1) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'user_id' => $user->id])->with(['tipoCliente', 'padre', 'user'])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2])->with(['tipoCliente', 'padre', 'user'])->get();
        }

        $clientes->map(function ($clientes) {
            $clientes->antiguedad = $this->antiguedad($clientes->inicio_relacion);
            $clientes->vigenciaMeses = $this->antiguedad($clientes->inicio_relacion, 'meses');
        });

        $arrVigencia = array();
        foreach ($clientes as $cliente) {
            $arrVigencia[] = array(
                $cliente->razon_social,
                $cliente->vigenciaMeses,
                $cliente->antiguedad,
                ($cliente->activo) ? 'Activos' : 'Inactivo',
                $cliente->user->name . '' . $cliente->user->last_name,
                ($cliente->inicio_relacion) ? date('d/m/Y', strtotime($cliente->inicio_relacion)) : '',
                $cliente->id,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrVigencia), 'recordsFiltered' => count($arrVigencia), 'data' => $arrVigencia);

        return response()->json($response, 200);
    }


    public function cerrados()
    {
        $user = auth()->user();

        $facturas = ProyectoFactura::with(['proyecto' => function ($sql) {
            return $sql->with(['cliente' => function ($sql) {
                return $sql->with(['user']);
            }]);
        }, 'estadoFactura'])->orderByDesc('fecha_factura')->get();

        $facturas->map(function ($factura) {
            $fC = Carbon::parse($factura->proyecto->fecha_cierre);
            $fF = Carbon::parse($factura->fecha_factura);
            $fP = Carbon::parse($factura->fecha_pago);

            $factura->proyecto->cliente->antiguedad = $this->antiguedad($factura->proyecto->cliente->inicio_relacion);
            $factura->mes_cierre = $fC->locale('es')->shortMonthName . '-' . $fC->format('y');
            $factura->mes_facturacion = $fF->locale('es')->shortMonthName . '-' . $fF->format('y');
            $factura->mes_pago = $fP->locale('es')->shortMonthName . '-' . $fP->format('y');
        });

        $cerrados = Cliente::whereHas('proyecto')->with('proyecto', function ($sql) {
            return $sql->with('proyectoFacturas', function ($sql) {
                return $sql->whereYear('fecha_factura', '=', date('Y'));
            });
        })->get();

        $cerrados->map(function ($cerrados) {
            $cerrados->proyecto->map(function ($proyectos) use ($cerrados) {
                $cerrados->sum_facturas += $proyectos->proyectoFacturas->sum('monto_venta');
            });
        });

        $totFact = $cerrados->sum('sum_facturas');

        $user->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Cerrados', 'ruta' => null]]);

        return view('pages.cliente.cerrados', compact('facturas', 'totFact'));
    }

    public function cerradosJSON()
    {

        $facturas = ProyectoFactura::with(['proyecto' => function ($sql) {
            return $sql->with(['cliente' => function ($sql) {
                return $sql->with(['user']);
            }]);
        }, 'estadoFactura'])->orderByDesc('fecha_factura')->get();

        $facturas->map(function ($factura) {
            $fC = Carbon::parse($factura->proyecto->fecha_cierre);
            $fF = Carbon::parse($factura->fecha_factura);
            $fP = Carbon::parse($factura->fecha_pago);

            $factura->proyecto->cliente->antiguedad = $this->antiguedad($factura->proyecto->cliente->inicio_relacion);
            $factura->mes_cierre = $fC->locale('es')->shortMonthName . '-' . $fC->format('y');
            $factura->mes_facturacion = $fF->locale('es')->shortMonthName . '-' . $fF->format('y');
            $factura->mes_pago = $fP->locale('es')->shortMonthName . '-' . $fP->format('y');
        });

        $arrCerrados = array();
        foreach ($facturas as $cerrado) {
            $arrCerrados[] = array(
                $cerrado->proyecto->cliente->antiguedad,
                $cerrado->mes_cierre,
                $cerrado->mes_facturacion,
                $cerrado->proyecto->cliente->razon_social,
                $cerrado->monto_venta,
                $cerrado->inscripcion_sence,
                $cerrado->estadoFactura->nombre,
                $cerrado->proyecto->cliente->user->name . ' ' . $cerrado->proyecto->cliente->user->last_name,
                $cerrado->proyecto->nombre,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrCerrados), 'recordsFiltered' => count($arrCerrados), 'data' => $arrCerrados);

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $holdings = Cliente::orderBy('razon_social', 'asc')->get();
        $usuarios = User::where(['activo' => 1])->orderBy('name', 'asc')->get();
        $tipoClientes = TipoCliente::where(['activo' => 1])->get();
        $hoy = Carbon::now();

        auth()->user()->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => route('cliente.index')], ['nombre' => 'Nuevo Cliente', 'ruta' => null]]);


        return view('pages.cliente.create', compact('holdings', 'usuarios', 'tipoClientes', 'hoy'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {

        $hoy = Carbon::now();

        if ($request->get('rut') != '') {
            $rules = ['rut' => 'cl_rut'];
            $customMessages = ['cl_rut' => 'El :attribute es inválido.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != '') {
            $rules = ['email' => 'email|confirmed'];
            $customMessages = ['confirmed' => 'Los correos deben coincidir.', 'email' => 'El campo :attribute debe ser un email válido.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'numeric|digits:9'];
            $customMessages = ['numeric' => 'El campo :attribute debe ser numérico.', 'digits' => 'El campo :attribute debe contener :digits dígitos.'];
            $this->validate($request, $rules, $customMessages);
        }

        $user = auth()->user();

        if ($user->rol_id == 2) {
            $rules = ['comercial' => 'required|exists:users,id', 'tipo_cliente' => 'required|exists:tipo_clientes,id'];
            $customMessages = ['required' => 'El campo :attribute es requerido.', 'exists' => 'El campo :attribute es inválido.'];
            $this->validate($request, $rules, $customMessages);
        }

        Cliente::create([
            'user_id' => $request->get('comercial'),
            'destino_user_id' => $request->get('comercial'),
            'tipo_cliente_id' => $request->get('tipo_cliente'),
            'padre_id' => $request->get('padre'),
            'rut' => ($request->get('rut')) ? Rut::parse($request->get('rut'))->format(Rut::FORMAT_WITH_DASH) : null,
            'razon_social' => $request->get('razon_social'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'cantidad_empleados' => $request->get('cantidad_empleados'),
            'rubro' => $request->get('rubro'),
            'direccion' => $request->get('direccion'),
            'inicio_ciclo' => $hoy,
            'inicio_relacion' => ($request->get('tipo_cliente') == 2) ? $hoy : null,
        ]);

        return redirect()->route('cliente.index')->with(['status' => 'Cliente creado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        $datos = Cliente::with(['tipoCliente', 'padre', 'user'])->find($cliente->id);
        $datos->rut_cliente = ($datos->rut) ? Rut::parse($datos->rut)->format(Rut::FORMAT_WITH_DASH) : '';
        $datos['success'] = 'ok';

        return response()->json($datos, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        $usuarios = User::where(['activo' => 1])->orderBy('name', 'asc')->get();
        $holdings = Cliente::where('id', '!=', $cliente->id)->get();
        $tipoClientes = TipoCliente::where(['activo' => 1])->get();
        $hoy = Carbon::now();

        $cliente->rut_format = ($cliente->rut) ? Rut::parse($cliente->rut)->format(Rut::FORMAT_WITH_DASH) : '';

        auth()->user()->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Clientes General', 'ruta' => route('cliente.index')], ['nombre' => 'Editar Cliente', 'ruta' => null]]);

        return view('pages.cliente.edit', compact('usuarios', 'holdings', 'cliente', 'tipoClientes', 'hoy'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, Cliente $cliente)
    {
        $user = auth()->user();
        $hoy = Carbon::now();

        if ($request->get('rut') != '') {
            $rules = ['rut' => 'cl_rut'];
            $customMessages = ['cl_rut' => 'El :attribute es inválido.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != '') {
            $rules = ['email' => 'email|confirmed'];
            $customMessages = ['confirmed' => 'Los correos deben coincidir.', 'email' => 'El campo :attribute debe ser un email válido.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'numeric|digits:9'];
            $customMessages = ['numeric' => 'El campo :attribute debe ser numérico.', 'digits' => 'El campo :attribute debe contener :digits dígitos.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($user->id != $cliente->user_id && $user->rol_id == 1) {
            return redirect()->route('cliente.edit', $cliente)->withInput()->withErrors([
                'razon_social' => 'Imposible modificar un cliente de otro comercial',
            ]);
        }

        if ($request->get('tipo_cliente') == '2') {
            $rules = ['inicio_relacion' => 'required|date|before_or_equal:today'];
            $customMessages = ['required' => 'El campo :attribute es requerido.', 'date' => 'El campo :attribute es una fecha inválida.', 'before_or_equal' => 'El campo :attribute debe ser menor a la fecha de hoy.'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('comercialDestino') != $cliente->destino_user_id) {
            $comercialOrigen = $cliente->destino_user_id;
        } else {
            $comercialOrigen = $cliente->user_id;
        }

        $cliente->fill([
            'user_id' => $comercialOrigen,
            'destino_user_id' => ($request->get('comercialDestino')) ? $request->get('comercialDestino') : null,
            'padre_id' => $request->get('padre'),
            'rut' => ($request->get('rut')) ? Rut::parse($request->get('rut'))->format(Rut::FORMAT_WITH_DASH) : null,
            'razon_social' => $request->get('razon_social'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'cantidad_empleados' => $request->get('cantidad_empleados'),
            'rubro' => $request->get('rubro'),
            'direccion' => $request->get('direccion'),
            'activo' => ($request->activo) ? 1 : 0,
            'inicio_relacion' => $request->get('inicio_relacion'),
        ]);

        if ($user->rol_id == 2) {
            $cliente->tipo_cliente_id = $request->get('tipo_cliente');
        }
        $cliente->save();

        return redirect()->route('cliente.index')->with(['status' => 'Cliente modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente, Request $request)
    {

        $cliente->delete();

        if ($request->rutaDestino) {
            $datos = array('success' => 'ok', 'msg' => 'Cliente eliminado satisfactoriamente', 'title' => 'Éxito');

            return response()->json($datos, 200);
        } else {
            return redirect()->route('cliente.index')->with(['title' => 'Éxito', 'status' => 'Cliente eliminado satisfactoriamente']);
        }
    }

    public function discard(Cliente $cliente, Request $request)
    {

        $cliente->tipo_cliente_id = 1;
        $cliente->user_id = $cliente->destino_user_id;
        $cliente->destino_user_id = null;
        $cliente->inicio_ciclo = Carbon::now();
        // $cliente->save();

        if ($request->rutaDestino) {

            $datos = array('success' => 'ok', 'msg' => 'Cliente desechado satisfactoriamente', 'title' => 'Éxito');

            return response()->json($datos, 200);
        } else {

            return redirect()->route('cliente.index')->with(['title' => 'Éxito', 'status' => 'Cliente desechado satisfactoriamente']);
        }
    }

    public function reportes(Request $request, $tipo)
    {

        $hoy = Carbon::today();

        if ($tipo == 1 || $tipo == 2) {
            $facturas = ProyectoFactura::with(['proyecto' => function ($sql) {
                return $sql->with(['cliente' => function ($sql) {
                    return $sql->with(['user']);
                }]);
            }, 'estadoFactura'])->orderBy('fecha_factura')->get();

            $facturas->map(function ($factura) {
                $fC = Carbon::parse($factura->proyecto->fecha_cierre);
                $fF = Carbon::parse($factura->fecha_factura);
                $fP = Carbon::parse($factura->fecha_pago);

                $factura->proyecto->cliente->antiguedad = $this->antiguedad($factura->proyecto->cliente->inicio_relacion);
                $factura->mes_cierre = $fC->locale('es')->shortMonthName . '-' . $fC->format('y');
                $factura->mes_facturacion = $fF->locale('es')->shortMonthName . '-' . $fF->format('y');
                $factura->mes_pago = $fP->locale('es')->shortMonthName . '-' . $fP->format('y');
            });

            $cerrados = Cliente::whereHas('proyecto')->with('proyecto', function ($sql) {
                return $sql->with('proyectoFacturas', function ($sql) {
                    return $sql->whereYear('fecha_factura', '=', date('Y'));
                });
            })->get();

            $cerrados->map(function ($cerrados) {
                $cerrados->proyecto->map(function ($proyectos) use ($cerrados) {

                    $cerrados->sum_facturas += $proyectos->proyectoFacturas->sum('monto_venta');
                });
            });

            $totFact = $cerrados->sum('sum_facturas');
        }

        if ($tipo == 3 || $tipo == 4) {

            $clientes = Cliente::with(['tipoCliente', 'padre', 'user'])->withCount(['proyecto'])->get();

            $clientes->map(function ($clientes) {
                $clientes->ciclo = $this->meses($clientes);
            });

            $groupCliente = $clientes->groupBy('activo');
            $arrEstados = array(0 => 'Inactivos', 1 => 'Activos');
            $arrGrupo = array('Activos' => 0, 'Inactivos' => 0);

            foreach ($groupCliente as $key => $cliente) {
                $arrGrupo[$arrEstados[$key]] = count($cliente);
            }
        }

        switch ($tipo) {
            case 1:

                $pdf = PDF::loadView('pages.cliente.cerrados-pdf', compact('facturas', 'totFact', 'tipo'))->setPaper('legal', 'landscape');
                $nombreArchivo = 'clientes-cerrados-' . $hoy->format('YmdHi') . '.pdf';

                return $pdf->download($nombreArchivo);

                break;
            case 2:
                $nombreArchivo = 'clientes-cerrados-' . $hoy->format('YmdHi') . '.xlsx';
                $data = compact('facturas', 'totFact', 'tipo');
                return Excel::download(new CerradosExport($data), $nombreArchivo);

                break;
            case 3:

                $pdf = PDF::loadView('pages.cliente.clientes-general-pdf', compact('clientes', 'arrGrupo', 'tipo'))->setPaper('legal', 'landscape');
                $nombreArchivo = 'clientes-general-' . $hoy->format('YmdHi') . '.pdf';

                return $pdf->download($nombreArchivo);
                break;
            case 4:
                $nombreArchivo = 'clientes-cerrados-' . $hoy->format('YmdHi') . '.xlsx';
                $data = compact('clientes', 'arrGrupo', 'tipo');
                return Excel::download(new ClientesGeneralExport($data), $nombreArchivo);
                break;
        }
    }

    public function updateInicioRelacion(Request $request, Cliente $cliente)
    {

        $cliente->inicio_relacion = $request->inicio_relacion;
        $cliente->save();

        return redirect()->route('cliente.vigencia')->with(['status' => 'Fecha de Inicio de Relación modificada satisfactoriamente', 'title' => 'Éxito']);
    }
}
