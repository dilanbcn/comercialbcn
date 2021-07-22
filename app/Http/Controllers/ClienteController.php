<?php

namespace App\Http\Controllers;

use App\Exports\CerradosExport;
use App\Exports\ClientesGeneralExport;
use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\EstadoFactura;
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

        $clientes = Cliente::with(['tipoCliente', 'user', 'compartido'])->withCount(['proyecto'])->orderBy('razon_social')->take(5)->get();

        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->dias($clientes);
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

    public function allClientes($contenido)
    {
        $user = auth()->user();

        $usuario = User::where(['id' => $user->id])->with('prospector')->first();

        if ($contenido == 'true') {
            $clientes = Cliente::with(['tipoCliente', 'user', 'compartido'])->withCount(['proyecto'])->orderBy('razon_social')->get();
        } else {
            $clientes = Cliente::with(['tipoCliente', 'user', 'compartido'])->whereNotNull('destino_user_id')->withCount(['proyecto'])->orderBy('razon_social')->get();
        }

        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->dias($clientes);
        });

        $arrClientes = array();
        foreach ($clientes as $cliente) {

            if ($contenido == 'true') {
                $nombreComercial = 'Prospecto Disponible';
                $comercialNombre = null;
                if ($cliente->destino_user_id) {
                    $comercialNombre = $cliente->destino->name . ' ' . $cliente->destino->last_name;
                }

                if ($comercialNombre) {
                    $nombreComercial = ($cliente->externo) ? $comercialNombre . " " . $cliente->externo : $comercialNombre;
                    $nombreComercial = ($cliente->compartido) ? $nombreComercial . ' / ' . $cliente->compartido->name . ' ' . $cliente->compartido->last_name : $nombreComercial;
                }
            } else {
                if (!$cliente->destino) {
                    $comercialNombre = $cliente->user->name . ' ' . $cliente->user->last_name;
                } else {
                    $comercialNombre = $cliente->destino->name . ' ' . $cliente->destino->last_name;
                }

                $nombreComercial = ($cliente->externo) ? $comercialNombre . " " . $cliente->externo : $comercialNombre;
                $nombreComercial = ($cliente->compartido) ? $nombreComercial . ' / ' . $cliente->compartido->name . ' ' . $cliente->compartido->last_name : $nombreComercial;
            }

            $inicioCiclo = ($cliente->inicio_ciclo) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '';

            $arrClientes[] = array(
                ($cliente->holding) ? $cliente->holding : '',
                $cliente->razon_social,
                $nombreComercial,
                $cliente->tipoCliente->nombre,
                ($cliente->tipo_cliente_id == 1) ? $inicioCiclo : '',
                ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '',
                ($cliente->activo) ? 'Activo' : 'Inactivo',
                $cliente->proyecto_count,
                $cliente->destino_user_id,
                $cliente->id,
                $cliente->compartido_user_id,
                ($usuario->prospector) ? $usuario->id_prospector : '',
                ($usuario->prospector) ? $usuario->prospector->name . ' ' . $usuario->prospector->last_name : '',

            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrClientes), 'recordsFiltered' => count($arrClientes), 'data' => $arrClientes);


        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clientesJSON(Request $request)
    {

        $termino = $request->search . '%';
        $clientes = Cliente::where('razon_social', 'LIKE', $termino)->distinct('razon_social')->pluck('razon_social');

        return  $clientes->toJson();
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

        $prospectos = Cliente::where(['tipo_cliente_id' => 1])->whereNull('destino_user_id')->with(['tipoCliente', 'user', 'destino'])->get();

        $arrProspectos = array();
        foreach ($prospectos as $prospecto) {

            $nomOrigen = ($prospecto->externo) ? $prospecto->user->name . ' ' . $prospecto->user->last_name . " " . $prospecto->externo : $prospecto->user->name . ' ' . $prospecto->user->last_name;
            $nomOrigen = ($prospecto->compartido) ? $nomOrigen . ' / ' . $prospecto->compartido->name . ' ' . $prospecto->compartido->last_name : $nomOrigen;

            $nomDestino = '';
            if ($prospecto->destino) {

                $nomDestino = ($prospecto->externo) ? $prospecto->destino->name . ' ' . $prospecto->destino->last_name . " " . $prospecto->externo : $prospecto->destino->name . ' ' . $prospecto->destino->last_name;
                $nomDestino = ($prospecto->compartido) ? $nomDestino . ' / ' . $prospecto->compartido->name . ' ' . $prospecto->compartido->last_name : $nomDestino;
            }

            $arrProspectos[] = array(
                $prospecto->razon_social,
                $nomOrigen,
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

        $clientes = Cliente::where(['tipo_cliente_id' => 2])->with(['tipoCliente', 'user'])->get();

        $groupCliente = $clientes->groupBy('actividad');
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

        $clientes = Cliente::where(['fue_cliente' => 1])->with(['tipoCliente', 'user'])->get();

        $clientes->map(function ($clientes) {
            $clientes->antiguedad = $this->antiguedad($clientes->inicio_relacion);
            $clientes->vigenciaMeses = $this->antiguedad($clientes->inicio_relacion, 'meses');
        });

        $arrVigencia = array();
        foreach ($clientes as $cliente) {

            $nombreComercial = ($cliente->externo) ? $cliente->user->name . ' ' . $cliente->user->last_name . " " . $cliente->externo : $cliente->user->name . ' ' . $cliente->user->last_name;
            $nombreComercial = ($cliente->compartido) ? $nombreComercial . ' / ' . $cliente->compartido->name . ' ' . $cliente->compartido->last_name : $nombreComercial;

            $arrVigencia[] = array(
                $cliente->razon_social,
                $cliente->vigenciaMeses,
                $cliente->antiguedad,
                $nombreComercial,
                ($cliente->inicio_relacion) ? date('d/m/Y', strtotime($cliente->inicio_relacion)) : '',
                ($cliente->actividad) ? 'Activos' : 'Inactivo',
                ($cliente->actividad) ? 'Activos' : 'Inactivo',
                $cliente->id,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrVigencia), 'recordsFiltered' => count($arrVigencia), 'data' => $arrVigencia);

        return response()->json($response, 200);
    }

    public function vigenciaActividad(Cliente $cliente)
    {
        $cliente->actividad = ($cliente->actividad == 1) ? 0 : 1;
        $cliente->save();

        $datos = array('success' => 'ok', 'msg' => 'Satatus actualizado satisfactoriamente', 'title' => 'Éxito');

        return response()->json($datos, 200);
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
                $cerrados->sum_facturas += ($proyectos->proyectoFacturas) ? $proyectos->proyectoFacturas->monto_venta : 0;
            });
        });

        $totFact = $cerrados->sum('sum_facturas');

        $user->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Cerrados', 'ruta' => null]]);

        $estados = EstadoFactura::where(['activo' => 1])->get();

        return view('pages.cliente.cerrados', compact('facturas', 'totFact', 'estados'));
    }

    public function cerradosJSON()
    {

        $facturas = ProyectoFactura::with(['proyecto' => function ($sql) {
            return $sql->with(['cliente' => function ($sql) {
                return $sql->with(['user']);
            }])->orderByDesc('fecha_cierre');
        }, 'estadoFactura'])->get();

        $status = EstadoFactura::where('activo', 1)->get();

        $arrCerrados = array();
        foreach ($facturas as $cerrado) {

            $fechaCierre = Carbon::parse($cerrado->proyecto->fecha_cierre);
            $fechaFactura = Carbon::parse($cerrado->fecha_factura);


            $nombreComercial = ($cerrado->proyecto->cliente->externo) ? $cerrado->proyecto->cliente->user->name . ' ' . $cerrado->proyecto->cliente->user->last_name . " " . $cerrado->proyecto->cliente->externo : $cerrado->proyecto->cliente->user->name . ' ' . $cerrado->proyecto->cliente->user->last_name;
            $nombreComercial = ($cerrado->proyecto->cliente->compartido) ? $nombreComercial . ' / ' . $cerrado->proyecto->cliente->compartido->name . ' ' . $cerrado->proyecto->cliente->compartido->last_name : $nombreComercial;

            $arrCerrados[] = array(
                $this->antiguedad($cerrado->proyecto->cliente->inicio_relacion),
                $cerrado->proyecto->fecha_cierre,
                $cerrado->fecha_factura,
                $cerrado->proyecto->cliente->razon_social,
                $cerrado->monto_venta,
                $cerrado->inscripcion_sence,
                $cerrado->estadoFactura->id,
                $nombreComercial,
                $cerrado->proyecto->nombre,
                $status,
                $cerrado->id,
                $cerrado->estadoFactura->nombre,
                $cerrado->proyecto->id,
                $cerrado->proyecto->cliente->destino_user_id,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrCerrados), 'recordsFiltered' => count($arrCerrados), 'data' => $arrCerrados);

        return response()->json($response, 200);
    }

    public function status(ProyectoFactura $proyectoFactura, Request $request)
    {

        $proyectoFactura->estado_factura_id = $request->status;
        $proyectoFactura->save();

        $datos = array('success' => 'ok', 'msg' => 'Status del proyecto actualizado satisfactoriamente', 'title' => 'Éxito');

        return response()->json($datos, 200);
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

        auth()->user()->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Nuevo Cliente', 'ruta' => null]]);


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
            'holding' => $request->get('holding'),
            'rut' => ($request->get('rut')) ? Rut::parse($request->get('rut'))->format(Rut::FORMAT_WITH_DASH) : null,
            'razon_social' => $request->get('razon_social'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'cantidad_empleados' => $request->get('cantidad_empleados'),
            'rubro' => $request->get('rubro'),
            'direccion' => $request->get('direccion'),
            'inicio_ciclo' => $hoy,
            'inicio_relacion' => ($request->get('tipo_cliente') == 2) ? $hoy : null,
            'fue_cliente' => ($request->get('tipo_cliente') == 2) ? 1 : 0,
            'actividad' => ($request->get('tipo_cliente') == 2) ? 1 : 0,
            'externo' => $request->get('externo'),
            'compartido_user_id' => ($request->get('compartido_user')) ? $request->get('compartido_user') : null,
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
        $datos = Cliente::with(['tipoCliente', 'user'])->find($cliente->id);
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

        if ($user->id != $cliente->user_id && ($user->rol_id == 1 || $user->rol_id == 3)) {
            return redirect()->route('cliente.edit', $cliente)->withInput()->withErrors([
                'razon_social' => 'Imposible modificar un cliente de otro comercial',
            ]);
        }

        if ($request->get('tipo_cliente') == '2') {
            $rules = ['inicio_relacion' => 'required|date|before_or_equal:today'];
            $customMessages = ['required' => 'El campo :attribute es requerido.', 'date' => 'El campo :attribute es una fecha inválida.', 'before_or_equal' => 'El campo :attribute debe ser menor a la fecha de hoy.'];
            $this->validate($request, $rules, $customMessages);
        }

        if (($request->get('comercialDestino') != $cliente->destino_user_id) && $cliente->destino_user_id != null) {
            $comercialOrigen = $cliente->destino_user_id;
            $inicioCiclo = Carbon::now();
        } else {
            $comercialOrigen = $cliente->user_id;
            $inicioCiclo = $cliente->inicio_ciclo;
        }


        $cliente->fill([
            'user_id' => $comercialOrigen,
            'destino_user_id' => ($request->get('comercialDestino')) ? $request->get('comercialDestino') : null,
            'holding' => $request->get('holding'),
            'rut' => ($request->get('rut')) ? Rut::parse($request->get('rut'))->format(Rut::FORMAT_WITH_DASH) : null,
            'razon_social' => $request->get('razon_social'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'cantidad_empleados' => $request->get('cantidad_empleados'),
            'rubro' => $request->get('rubro'),
            'direccion' => $request->get('direccion'),
            'activo' => ($request->activo) ? 1 : 0,
            'inicio_relacion' => $request->get('inicio_relacion'),
            'externo' => $request->get('externo'),
            'compartido_user_id' => ($request->get('compartido_user')) ? $request->get('compartido_user') : null,
            'inicio_ciclo' => $inicioCiclo,

        ]);

        if ($user->rol_id == 2) {
            $cliente->tipo_cliente_id = $request->get('tipo_cliente');

            if ($cliente->fue_cliente == 0) {

                $cliente->fue_cliente = ($request->get('tipo_cliente') == 2) ? 1 : 0;
            }
            $cliente->actividad = ($request->get('tipo_cliente') == 2) ? 1 : 0;
        }

        $cliente->save();

        $rutaDestino = ($request->rutaDestino) ? $request->rutaDestino : 'cliente.index';

        return redirect()->route($rutaDestino)->with(['status' => 'Cliente modificado satisfactoriamente', 'title' => 'Éxito']);
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
        $cliente->save();

        if ($request->rutaDestino) {

            $datos = array('success' => 'ok', 'msg' => 'Cliente desechado satisfactoriamente', 'title' => 'Éxito');

            return response()->json($datos, 200);
        } else {

            return redirect()->route('cliente.index')->with(['title' => 'Éxito', 'status' => 'Cliente desechado satisfactoriamente']);
        }
    }

    public function restartCiclo()
    {

        Cliente::where(['tipo_cliente_id' => 1])->update(['inicio_ciclo' => Carbon::now()]);

        $datos = array('success' => 'ok', 'msg' => 'Ciclo reiniciado satisfactoriamente', 'title' => 'Éxito');

        return response()->json($datos, 200);
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

                    $cerrados->sum_facturas += ($proyectos->proyectoFacturas) ? $proyectos->proyectoFacturas->monto_venta : 0;
                });
            });

            $totFact = $cerrados->sum('sum_facturas');
        }

        if ($tipo == 3 || $tipo == 4) {

            $clientes = Cliente::with(['tipoCliente', 'user'])->withCount(['proyecto'])->get();

            $clientes->map(function ($clientes) {
                $clientes->ciclo = $this->dias($clientes);
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

    public function acciones(Request $request)
    {
        $user = auth()->user();

        $comerciales = User::whereIn('rol_id', [1, 2])->get();

        $user->breadcrumbs = collect([['nombre' => 'Cliente', 'ruta' => null], ['nombre' => 'Acciones Masivas', 'ruta' => null]]);


        return view('pages.cliente.acciones', compact('comerciales'));
    }

    public function discardAll(Request $request)
    {

        foreach ($request->get('clientes') as $clienteId) {

            $cliente = Cliente::find($clienteId);

            $cliente->tipo_cliente_id = 1;
            $cliente->user_id = $cliente->destino_user_id;
            $cliente->destino_user_id = null;
            $cliente->inicio_ciclo = Carbon::now();
            $cliente->save();
        }

        $datos = array('success' => 'ok', 'msg' => 'Clientes desechados satisfactoriamente', 'title' => 'Éxito');

        return response()->json($datos, 200);
    }

    public function asignAll(Request $request)
    {

        foreach ($request->get('clientes') as $clienteId) {

            $cliente = Cliente::find($clienteId);

            $cliente->destino_user_id = $request->get('comercialDestino');
            $cliente->inicio_ciclo = Carbon::now();

            $cliente->save();
        }

        $datos = array('success' => 'ok', 'msg' => 'Clientes asignados satisfactoriamente', 'title' => 'Éxito');

        return response()->json($datos, 200);
    }
}
