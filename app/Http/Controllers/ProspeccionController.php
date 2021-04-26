<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteContactoRequest;
use App\Models\Cliente;
use App\Models\ClienteComunicacion;
use App\Models\ClienteContacto;
use App\Models\Proyecto;
use App\Models\ProyectoFactura;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProspeccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function contactos()
    {
        $user = auth()->user();
        $contactos = ClienteContacto::with(['cliente' => function ($sql) {
            return $sql->with(['tipoCliente', 'user']);
        }])->whereHas('cliente', function ($sql) {
            $sql->where(['activo' => true]);
        })->get();

        if ($user->rol_id == 4) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->whereHas('user', function ($sql) use ($user) {
                return $sql->where('id_prospector', $user->id);
            })->get();
        }

        $user->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Contactos', 'ruta' => null]]);

        return view('pages.prospeccion.contacto', compact('contactos', 'clientes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function contactoStore(ClienteContactoRequest $request)
    {
        $rules = ['cliente' => 'required|exists:clientes,id'];
        $customMessages = [
            'required' => 'El campo :attribute es requerido',
            'exists' => 'El campo :attribute es inválido'
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->get('celular') != '') {
            $rules = ['celular' => 'starts_with:9|digits:9|numeric'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 9',
                'digits' => 'El campo :attribute debe tener :digits digítos',
                'numeric' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'digits:9|numeric|starts_with:2'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 2',
                'digits' => 'El campo :attribute debe tener :digits digítos',
                'numeric' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != '') {
            $rules = ['email' => 'email|confirmed'];
            $customMessages = ['email' => 'El campo :attribute es inválido', 'confirmed' => 'El correo no coincide'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') == null && $request->get('email') == null && $request->get('celular') == null) {
            return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                ['telefono' => 'Debe seleccionar al menos una forma de contacto', 'celular' => 'Debe seleccionar al menos una forma de contacto', 'email' => 'Debe seleccionar al menos una forma de contacto']
            );
        }

        $existe = ClienteContacto::where(['nombre' => $request->get('nombre'), 'cliente_id' => $request->get('cliente')])
            ->where(function ($sql) use ($request) {
                $sql->orWhere(['telefono' => $request->get('telefono'), 'correo' => $request->get('correo'), 'celular' => $request->get('celular')]);
            })->first();

        if ($existe) {
            return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                ['nombre' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']
            );
        }

        ClienteContacto::create([
            'cliente_id' => $request->get('cliente'),
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'cargo' => $request->get('cargo'),
            'correo' => $request->get('correo'),
            'telefono' => $request->get('telefono'),
            'celular' => $request->get('celular'),
        ]);

        return redirect()->route('prospeccion.contactos')->with(['status' => 'Contacto creado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClienteContacto  $clienteContacto
     * @return \Illuminate\Http\Response
     */
    public function contactoEdit(ClienteContacto $clienteContacto)
    {
        $clienteContacto->success = 'ok';

        return response()->json($clienteContacto, 200);
    }

    public function contactoUpdate(ClienteContactoRequest $request, ClienteContacto $clienteContacto)
    {
        $rules = ['cliente' => 'required|exists:clientes,id'];
        $customMessages = [
            'required' => 'El campo :attribute es requerido',
            'exists' => 'El campo :attribute es inválido'
        ];
        $this->validate($request, $rules, $customMessages);

        if ($request->get('celular') != '') {
            $rules = ['celular' => 'starts_with:9|digits:9|numeric'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 9',
                'digits' => 'El campo :attribute debe tener :digits digítos',
                'numeric' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'digits:9|numeric|starts_with:2'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 2',
                'digits' => 'El campo :attribute debe tener :digits digítos',
                'numeric' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != '') {
            $rules = ['email' => 'email|confirmed'];
            $customMessages = ['email' => 'El campo :attribute es inválido', 'confirmed' => 'El correo no coincide'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') == null && $request->get('email') == null && $request->get('celular') == null) {
            return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                ['telefono' => 'Debe seleccionar al menos una forma de contacto', 'celular' => 'Debe seleccionar al menos una forma de contacto', 'email' => 'Debe seleccionar al menos una forma de contacto']
            );
        }

        if ($request->get('cliente') != $clienteContacto->cliente_id) {
            $existe = ClienteContacto::where(['nombre' => $request->get('nombre'), 'cliente_id' => $request->get('cliente')])
                ->where(function ($sql) use ($request) {
                    $sql->orWhere(['telefono' => $request->get('telefono'), 'correo' => $request->get('correo'), 'celular' => $request->get('celular')]);
                })->first();

            if ($existe) {
                return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                    ['nombre' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']
                );
            }
        }

        $clienteContacto->fill([
            'cliente' => $request->get('cliente'),
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'cargo' => $request->get('cargo'),
            'telefono' => $request->get('telefono'),
            'celular' => $request->get('celular'),
            'email' => $request->get('email'),
            'activo' => ($request->activo) ? 1 : 0,
        ]);

        if ($clienteContacto->isDirty()) {
            $clienteContacto->save();
        }

        return redirect()->route('prospeccion.contactos')->with(['status' => 'Contacto modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filtro = ($request->filtro) ? strtolower($request->filtro) : null;

        $usuarios = User::with('prospector')->get();

        $prospectores = $usuarios->filter(function ($comercial) {
            return $comercial->rol_id == 5;
        });

        $comerciales = $usuarios->filter(function ($comercial) {
            return $comercial->rol_id != 5;
        })->when($filtro, function ($query) use ($filtro) {
            return $query->filter(function ($user) use ($filtro) {
                if ($filtro == 'sin_prospector') {
                    return $user->id_prospector == '';
                } else {
                    return $user->id_prospector == $filtro;
                }
            });
        });

        auth()->user()->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Asignación Prospectores', 'ruta' => null]]);


        return view('pages.prospeccion.index', compact('comerciales', 'prospectores', 'filtro'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (!$request->get('prospectorId')) {
            return redirect()->route('prospeccion.asignacion.index')->with(['status' => 'El prospector es requerido', 'title' => 'Error', 'estilo' => 'error']);
        }

        if (count($request->get('usuario')) <= 0) {
            return redirect()->route('prospeccion.asignacion.index')->with(['status' => 'No hay usuarios que asignar', 'title' => 'Error', 'estilo' => 'error']);
        }


        User::whereIn("id", $request->get('usuario'))->update(['id_prospector' => $request->get('prospectorId')]);

        return redirect()->route('prospeccion.asignacion.index')->with(['status' => 'Prospector asignado satiosfactoriamente', 'title' => 'success']);
    }


    public function indicadores(Request $request)
    {
        $user = auth()->user();

        if ($user->rol_id == 4) {

            $comerciales = User::where(['rol_id' => 1])->get();
            $show = false;
            $arrHead = null;
            $arrData = null;
            $inptComercial = null;
            $desde = null;
            $hasta = null;

            if ($request->_token) {

                if ($request->get('comercialId') != 'all') {
                    $rules = ['comercialId' => 'exists:users,id'];
                    $customMessages = ['exists' => 'El :attribute es inválido.'];
                    $this->validate($request, $rules, $customMessages);
                }

                $rules = [
                    'comercialId' => 'required',
                    'desde' => 'required|date|date_format:Y-m-d|before:hasta',
                    'hasta' => 'required|date|date_format:Y-m-d|after:desde|before_or_equal:today'
                ];
                $customMessages = [
                    'required' => 'El :attribute es requerido.',
                    'date' => 'El campo :attribute debe ser una fecha válida.',
                    'date_format' => 'El formato de :attribute debe YYYY-MM-DD.',
                    'before' => 'La fecha :attribute debe ser menor a la fecha hasta.',
                    'after' => 'La fecha :attribute debe ser mayor a la fecha desde.',
                    'before_or_equal' => 'La fecha :attribute debe ser menor o igual al día de hoy.',

                ];
                $this->validate($request, $rules, $customMessages);

                $inptComercial = $request->get('comercialId');
                $desde = $request->get('desde');
                $hasta = $request->get('hasta');

                $comercialesCollect = ($request->comercialId != 'all') ? User::where(['id' => $request->comercialId])->get() : $comerciales;
                $show = true;

                $inicio = Carbon::createMidnightDate($request->desde);
                $fechaFinal = Carbon::createMidnightDate($request->hasta);
                $arrData = array();

                if ($inicio->diffInMonths($fechaFinal) < 1) {
                    return redirect()->route('prospeccion.indicadores')->withInput()->withErrors([
                        'desde' => 'El rango de fechas debe ser mayor a un mes',
                        'hasta' => 'El rango de fechas debe ser mayor a un mes',
                    ]);
                }

                $arrData[0]['contactados'][] = '1.- Consolidado';
                $arrData[0]['contactados'][] = 'Clientes Contactados';
                $arrData[0]['reuniones'][] = '1.- Consolidado';
                $arrData[0]['reuniones'][] = 'Reuniones Agendadas';
                $arrData[0]['cerrados'][] = '1.- Consolidado';
                $arrData[0]['cerrados'][] = 'Clientes Cerrados';
                $arrData[0]['ingresos'][] = '1.- Consolidado';
                $arrData[0]['ingresos'][] = 'Ingresos Generados';

                $cont = 0;

                foreach ($comercialesCollect as $comercial) {
                    $fechaInicio = Carbon::createMidnightDate($request->desde);

                    $meses = $fechaInicio->diffInMonths($fechaFinal);
                    $arrData[$comercial->id]['contactados'][] = $comercial->name . ' ' . $comercial->last_name;
                    $arrData[$comercial->id]['contactados'][] = 'Clientes Contactados';

                    $arrData[$comercial->id]['reuniones'][] = $comercial->name . ' ' . $comercial->last_name;
                    $arrData[$comercial->id]['reuniones'][] = 'Reuniones Agendadas';

                    $arrData[$comercial->id]['cerrados'][] = $comercial->name . ' ' . $comercial->last_name;
                    $arrData[$comercial->id]['cerrados'][] = 'Clientes Cerrados';

                    $arrData[$comercial->id]['ingresos'][] = $comercial->name . ' ' . $comercial->last_name;
                    $arrData[$comercial->id]['ingresos'][] = 'Ingresos Generados';
                    for ($i = 0; $i < $meses; $i++) {

                        // **********CONSOLIDADO
                        // CLIENTES CONTACTADOS
                        $consClientes = Cliente::whereMonth('inicio_ciclo', '=', $inicio->month)->whereYear('inicio_ciclo', '=', $inicio->year)
                            ->get()->count();
                        // REUNIONES AGENDADAS
                        $consReuniones = ClienteComunicacion::whereMonth('fecha_reunion', '=', $fechaInicio->month)->whereYear('fecha_reunion', '=', $fechaInicio->year)
                            ->get()->count();
                        // CLIENTES CERRADOS
                        $consCerrados = Cliente::whereMonth('inicio_relacion', '=', $fechaInicio->month)->whereYear('inicio_relacion', '=', $fechaInicio->year)
                            ->get()->count();
                        // INGRESOS
                        // $consFacturas = ProyectoFactura::whereMonth('fecha_pago', '=', $fechaInicio->month)
                        //     ->whereYear('fecha_pago', '=', $fechaInicio->year)->get();
                        // $consIngresos = $consFacturas->sum('monto_venta');
                        $consFacturas = Proyecto::whereHas('proyectoFacturas', function ($sql) use ($fechaInicio) {
                            return $sql->whereMonth('fecha_pago', '=', $fechaInicio->month)
                                ->whereYear('fecha_pago', '=', $fechaInicio->year);
                        })->get();

                        $consIngresos = $consFacturas->proyectoFacturas->sum('monto_venta');
                        // **********FIN CONSOLIDADO


                        // CLIENTES CONTACTADOS
                        $totClientes = Cliente::where(['user_id' => $comercial->id])->whereMonth('inicio_ciclo', '=', $fechaInicio->month)
                            ->whereYear('inicio_ciclo', '=', $fechaInicio->year)->get()->count();

                        // REUNIONES AGENDADAS
                        $totReuniones = ClienteComunicacion::with(['cliente'])->whereHas('cliente', function ($sql) use ($comercial) {
                            return $sql->where(['user_id' => $comercial->id]);
                        })->whereMonth('fecha_reunion', '=', $fechaInicio->month)->whereYear('fecha_reunion', '=', $fechaInicio->year)->get()->count();

                        // CLIENTES CERRADOS
                        $totCerrados = Cliente::where(['user_id' => $comercial->id])->whereMonth('inicio_relacion', '=', $fechaInicio->month)
                            ->whereYear('inicio_relacion', '=', $fechaInicio->year)->get()->count();

                        // INGRESOS
                        $facturas = ProyectoFactura::whereHas('proyecto', function ($sql) use ($comercial) {
                            return $sql->whereHas('cliente', function ($sql) use ($comercial) {
                                return $sql->where(['user_id' => $comercial->id]);
                            });
                        })->whereMonth('fecha_pago', '=', $fechaInicio->month)->whereYear('fecha_pago', '=', $fechaInicio->year)->get();

                        $totalIngresos = $facturas->sum('monto_venta');

                        $mes = $fechaInicio->locale('es')->shortMonthName . '-' . $fechaInicio->format('y');
                        $fechaInicio->addMonth();


                        // CONSOLIDADO DATOS
                        if ($cont == 0) {
                            $arrData[0]['contactados'][] = $consClientes;
                            $arrData[0]['contactados'][] = '100%';
                            $arrData[0]['reuniones'][] = $consReuniones;
                            $arrData[0]['reuniones'][] = '100%';
                            $arrData[0]['cerrados'][] = $consCerrados;
                            $arrData[0]['cerrados'][] = '100%';
                            $arrData[0]['ingresos'][] = number_format($consIngresos, 0, ',', '.');
                            $arrData[0]['ingresos'][] = '100%';
                        }
                        // FIN CONSOLIDADO DATOS

                        // COMERCIALES DATOS
                        // CONTACTADOS
                        $arrData[$comercial->id]['contactados'][] = $totClientes;
                        $arrData[$comercial->id]['contactados'][] = ($consClientes > 0) ? round(($totClientes * 100) / $consClientes) . '%' : '0%';

                        // REUNIONES
                        $arrData[$comercial->id]['reuniones'][] = $totReuniones;
                        $arrData[$comercial->id]['reuniones'][] = ($consReuniones > 0) ? round(($totReuniones * 100) / $consReuniones) . '%' : '0%';

                        // CERRADOS
                        $arrData[$comercial->id]['cerrados'][] = $totCerrados;
                        $arrData[$comercial->id]['cerrados'][] = ($consCerrados > 0) ? round(($totCerrados * 100) / $consCerrados) . '%' : '0%';

                        // INGRESOS
                        $arrData[$comercial->id]['ingresos'][] = number_format($totalIngresos, 0, ',', '.');
                        $arrData[$comercial->id]['ingresos'][] = ($consIngresos > 0) ? round(($totalIngresos * 100) / $consIngresos) . '%' : '0%';
                        // FIN COMERCIALES DATOS

                        // HEAD TABLA 
                        $arrHead[strtoupper($mes)] = strtoupper($mes);
                    }
                    $cont++;
                }
            }

            $user->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Indicadores', 'ruta' => null]]);

            return view('pages.prospeccion.indicadores', compact('arrHead', 'arrData', 'show', 'comerciales', 'inptComercial', 'desde', 'hasta'));
        } else {
            return redirect()->route('cliente-comunicacion.index')->with(['status' => 'No tiene acceso a esa vista', 'title' => 'Error', 'estilo' => 'error']);
        }
    }
}
