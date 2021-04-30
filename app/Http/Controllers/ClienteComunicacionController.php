<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteComunicacionRequest;
use App\Mail\ReunionModificadaMail;
use App\Models\Cliente;
use App\Models\ClienteComunicacion;
use App\Models\ClienteContacto;
use App\Models\TipoComunicacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ClienteComunicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hoy = Carbon::today();
        $user = auth()->user();

        if ($user->rol_id == 4) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion', 'clienteContactos'])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->whereHas('user', function ($sql) use ($user) {
                return $sql->where(['id_prospector' => $user->id]);
            })->with(['clienteComunicacion', 'clienteContactos'])->get();
        }

        $tipoComunicaciones = TipoComunicacion::where(['activo' => 1])->get();

        $user->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Llamados y Reuniones', 'ruta' => null]]);


        return view('pages.cliente_comunicacion.index', compact('clientes', 'hoy', 'tipoComunicaciones'));
    }

    public function indexJSON()
    {
        $user = auth()->user();

        if ($user->rol_id == 4) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion', 'clienteContactos'])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->whereHas('user', function ($sql) use ($user) {
                return $sql->where(['id_prospector' => $user->id]);
            })->with(['clienteComunicacion', 'clienteContactos'])->get();
        }

        $arrComunicacion = array();
        foreach ($clientes as $cliente) {
            $arrComunicacion[] = array(
                $cliente->razon_social,
                $cliente->telefono,
                $cliente->email,
                ($cliente->activo == 1) ? 'Activos' : 'Inactivo',
                $cliente->id,
                $cliente->clienteComunicacion->count(),
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrComunicacion), 'recordsFiltered' => count($arrComunicacion), 'data' => $arrComunicacion);


        return response()->json($response, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resumen()
    {

        auth()->user()->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Llamados y Reuniones', 'ruta' => route('cliente-comunicacion.index')], ['nombre' => 'Vista Resumen', 'ruta' => null]]);

        return view('pages.cliente_comunicacion.index_resumen');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function resumenJSON()
    {

        $clientes = Cliente::whereHas('clienteComunicacion')->with(['clienteComunicacion', 'destino', 'clienteContactos'])->with('user', function ($sql) {
            return $sql->with('prospector');
        })->get();


        $arrComunicacion = array();
        foreach ($clientes as $cliente) {

        
            $arrContactos = array();
            if ($cliente->clienteContactos) {
                foreach ($cliente->clienteContactos as $key => $contacto) {
                    $arrNumContacto = array();

                    if ($contacto->correo) {
                        $arrNumContacto[] = '<li style="list-style-type: none;">Correo: '.$contacto->correo.'</li>';
                    }
                    if ($contacto->telefono) {
                        $arrNumContacto[] = '<li style="list-style-type: none;">Telefono: '.$contacto->telefono.'</li>';
                    }
                    if ($contacto->celular) {
                        $arrNumContacto[] = '<li style="list-style-type: none;">Fono: '.$contacto->celular.'</li>';
                    }

                    $strNumeros = '';
                    if (count($arrNumContacto) > 0) {
                        $strNumeros = '<ul>'.implode('',$arrNumContacto).'</ul>';
                    }
                    
                    $arrContactos[] = '<li style="list-style-type: none;">'. $contacto->nombre . ' ' . $contacto->apellido . $strNumeros . '</li>';
                }
            }

            $arrComunicaciones = array();
            if ($cliente->clienteComunicacion) {
                foreach ($cliente->clienteComunicacion as $key => $comunicacion) {

                    $fecha = Carbon::parse($comunicacion->created_at);

                    $strReunion = '';
                    if ($comunicacion->fecha_reunion) {
                        $fReunion = Carbon::parse($comunicacion->fecha_reunion);
                        $strReunion .= '<li style="list-style-type: none;" class="text-sm"><span class="font-weight-bold">'.$fecha->format('d-m-Y').'</span>  <ul><li style="list-style-type: none;">'.$comunicacion->observaciones.'</li><li style="list-style-type: none;"><i class="far fa-calendar-check" title="Reunión Agendada"></i> '.$fReunion->format('d-m-Y \\a \\l\\a\\s H:i').'</li></ul> </li>';
                    } else {
                        $strReunion .= '<li style="list-style-type: none;" class="text-sm"><span class="font-weight-bold">'.$fecha->format('d-m-Y').':</span><span> '.$comunicacion->observaciones.'</span>'.$strReunion.'</li>';
                    }

                    $arrComunicaciones[] = $strReunion;
                }
            }

            $arrComunicacion[] = array(
                '',
                ($cliente->user->prospector) ? $cliente->user->prospector->name . ' ' . $cliente->user->prospector->last_name : '',
                ($cliente->user) ? $cliente->user->name . ' ' . $cliente->user->last_name : '',
                $cliente->razon_social,
                '',
                '<ul>' . implode('', $arrContactos) . '</ul>',
                '<ul>' . implode('', $arrComunicaciones) . '</ul>',
                $cliente->rubro,
                $cliente->direccion,
                $cliente->email,
                ($cliente->cantidad_empleados) ? $cliente->cantidad_empleados : 0,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrComunicacion), 'recordsFiltered' => count($arrComunicacion), 'data' => $arrComunicacion);

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteComunicacionRequest $request)
    {

        if ($request->get('fechaReunion') != '') {
            $rules = ['fechaReunion' => 'date|after_or_equal:fechaContacto', 'horaReunion' => 'required|date_format:H:i'];
            $customMessages = [
                'required' => 'El campo :attribute es requerido',
                'date' => 'El campo :attribute es una fecha inválida',
                'before_or_equal' => 'El campo :attribute debe ser mayor al campo Fecha Contacto'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('nuevoContacto') == 1) {

            if ($request->get('celularContacto') != '') {
                $rules = ['celularContacto' => 'starts_with:9|digits:9|numeric'];
                $customMessages = [
                    'starts_with' => 'El campo :attribute debe comenzar con el número 9',
                    'digits' => 'El campo :attribute debe tener :digits digítos',
                    'numeric' => 'El campo :attribute es inválido'
                ];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('fonoContacto') != '') {
                $rules = ['fonoContacto' => 'digits:9|numeric|starts_with:2'];
                $customMessages = [
                    'starts_with' => 'El campo :attribute debe comenzar con el número 2',
                    'digits' => 'El campo :attribute debe tener :digits digítos',
                    'numeric' => 'El campo :attribute es inválido'
                ];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('correoContacto') != '') {
                $rules = ['correoContacto' => 'email'];
                $customMessages = ['email' => 'El campo :attribute es inválido'];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('fonoContacto') == null && $request->get('correoContacto') == null && $request->get('celularContacto') == null) {
                return redirect()->route('cliente-comunicacion.index')->withInput()->withErrors([
                    'fonoContacto' => 'Debe seleccionar al menos una forma de contacto',
                    'celularContacto' => 'Debe seleccionar al menos una forma de contacto',
                    'correoContacto' => 'Debe seleccionar al menos una forma de contacto'
                ]);
            }

            $existe = ClienteContacto::where(['nombre' => $request->get('nombreContacto'), 'cliente_id' => $request->get('cliente')])
                ->where(function ($sql) use ($request) {
                    $sql->orWhere(['telefono' => $request->get('fonoContacto'), 'correo' => $request->get('correoContacto'), 'celular' => $request->get('celularContacto')]);
                })->first();

            if ($existe) {
                return redirect()->route('cliente-comunicacion.index')->withInput()->withErrors(
                    ['nombreContacto' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']
                );
            }

            $clienteContacto = ClienteContacto::create([
                'cliente_id' => $request->get('cliente'),
                'nombre' => $request->get('nombreContacto'),
                'apellido' => $request->get('apellidoContacto'),
                'cargo' => $request->get('cargoContacto'),
                'correo' => $request->get('correoContacto'),
                'telefono' => $request->get('fonoContacto'),
                'celular' => $request->get('celularContacto'),
            ]);
        } else {

            $rules = ['contactoId' => 'required|exists:cliente_contacto,id'];
            $customMessages = [
                'required' => 'Debe seleccionar un contacto o crear uno nuevo',
                'exists' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);

            $clienteContacto = ClienteContacto::find($request->get('contactoId'));
        }

        $user = auth()->user();

        $stringFecha = $request->get('fechaReunion') . ' ' . $request->get('horaReunion');
        $fechaReunion = new Carbon($stringFecha);

        $cliente = Cliente::with(['user'])->find($request->get('cliente'));

        ClienteComunicacion::create([
            'cliente_id' => $request->get('cliente'),
            'tipo_comunicacion_id' => $request->get('tipoComunicacion'),
            'prospector_id' => $user->id,
            'prospector_nombre' => $cliente->user->name . ' ' . $cliente->user->last_name,
            'comercial_id' => $cliente->user->id,
            'comercial_nombre' => $user->name . ' ' . $user->last_name,
            'fecha_contacto' => $request->get('fechaContacto'),
            'fecha_reunion' => ($request->get('fechaReunion')) ? $fechaReunion->format('Y-m-d H:i:00') : null,
            'linkedin' => ($request->get('linkedin')) ? $request->get('linkedin') : 0,
            'envia_correo' => ($request->get('envioCorreo')) ? $request->get('envioCorreo') : 0,
            'respuesta' => ($request->get('respuesta')) ? $request->get('respuesta') : 0,
            'observaciones' => $request->get('observaciones'),
            'cliente_contacto_id' => $clienteContacto->id,
            'nombre_contacto' => $clienteContacto->nombre,
            'apellido_contacto' => $clienteContacto->apellido,
            'cargo_contacto' => $clienteContacto->cargo,
            'correo_contacto' => $clienteContacto->correo,
            'telefono_contacto' => $clienteContacto->telefono,
            'celular_contacto' => $clienteContacto->celular
        ]);

        $ruta = (!$request->get('inpt-ruta')) ? 'cliente-comunicacion.index' : 'cliente-comunicacion.conversacion';

        return redirect()->route($ruta, ($request->get('inpt-ruta')) ? $request->get('cliente') : null)->with(['status' => 'Registro creado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClienteComunicacion  $clienteComunicacion
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteComunicacion $clienteComunicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClienteComunicacion  $clienteComunicacion
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteComunicacion $clienteComunicacion)
    {
        $clienteComunicacion->success = 'ok';

        return response()->json($clienteComunicacion, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClienteComunicacion  $clienteComunicacion
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteComunicacionRequest $request, ClienteComunicacion $clienteComunicacion)
    {
        if ($request->get('fechaReunion')) {
            $rules = ['fechaReunion' => 'date|after_or_equal:fechaContacto|after_or_equal:today', 'horaReunion' => 'required|date_format:H:i'];
            $customMessages = [
                'required' => 'El campo :attribute es requerido',
                'date' => 'El campo :attribute es una fecha inválida',
                'after_or_equal' => 'El campo :attribute debe ser mayor que el día de hoy y la fecha de contacto',
                'date_format' => 'El campo :attribute es invádlido'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('nuevoContacto') == 1) {

            if ($request->get('celularContacto') != '') {
                $rules = ['celularContacto' => 'starts_with:9|digits:9|numeric'];
                $customMessages = [
                    'starts_with' => 'El campo :attribute debe comenzar con el número 9',
                    'digits' => 'El campo :attribute debe tener :digits digítos',
                    'numeric' => 'El campo :attribute es inválido'
                ];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('fonoContacto') != '') {
                $rules = ['fonoContacto' => 'digits:9|numeric|starts_with:2'];
                $customMessages = [
                    'starts_with' => 'El campo :attribute debe comenzar con el número 2',
                    'digits' => 'El campo :attribute debe tener :digits digítos',
                    'numeric' => 'El campo :attribute es inválido'
                ];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('correoContacto') != '') {
                $rules = ['correoContacto' => 'email'];
                $customMessages = ['email' => 'El campo :attribute es inválido'];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('fonoContacto') == null && $request->get('correoContacto') == null && $request->get('celularContacto') == null) {
                $rutaError = ($request->calendario == 'calendario') ? 'cliente-comunicacion.calendario' : 'cliente-comunicacion.conversacion';
                return redirect()->route($rutaError)->withInput()->withErrors([
                    'fonoContacto' => 'Debe seleccionar al menos una forma de contacto',
                    'celularContacto' => 'Debe seleccionar al menos una forma de contacto',
                    'correoContacto' => 'Debe seleccionar al menos una forma de contacto'
                ]);
            }

            $existe = ClienteContacto::where(['nombre' => $request->get('nombreContacto'), 'cliente_id' => $request->get('cliente')])
                ->where(function ($sql) use ($request) {
                    $sql->orWhere(['telefono' => $request->get('fonoContacto'), 'correo' => $request->get('correoContacto'), 'celular' => $request->get('celularContacto')]);
                })->first();

            if ($existe) {
                $rutaError = ($request->calendario == 'calendario') ? 'cliente-comunicacion.calendario' : 'cliente-comunicacion.conversacion';
                return redirect()->route($rutaError)->withInput()->withErrors(
                    ['nombreContacto' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']
                );
            }

            $clienteContacto = ClienteContacto::create([
                'cliente_id' => $request->get('cliente'),
                'nombre' => $request->get('nombreContacto'),
                'apellido' => $request->get('apellidoContacto'),
                'cargo' => $request->get('cargoContacto'),
                'correo' => $request->get('correoContacto'),
                'telefono' => $request->get('fonoContacto'),
                'celular' => $request->get('celularContacto'),
            ]);
        } else {

            $rules = ['contactoId' => 'required|exists:cliente_contacto,id'];
            $customMessages = [
                'required' => 'Debe seleccionar un contacto o crear uno nuevo',
                'exists' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);

            $clienteContacto = ClienteContacto::find($request->get('contactoId'));
        }

        $user = auth()->user();

        $stringFecha = $request->get('fechaReunion') . ' ' . $request->get('horaReunion');
        $fechaReunion = new Carbon($stringFecha);

        $fechaRegistrada = new Carbon($clienteComunicacion->fecha_reunion);
        $fechaFormulario = new Carbon($request->get('fechaReunion'));

        $clienteCom = ClienteComunicacion::with(['cliente' => function ($sql) {
            return $sql->with(['user']);
        }])->find($clienteComunicacion->id);


        $clienteComunicacion->fill([
            'tipo_comunicacion_id' => $request->get('tipoComunicacion'),
            'prospector_id' => $user->id,
            'prospector_nombre' => $clienteCom->cliente->user->name . ' ' . $clienteCom->cliente->user->last_name,
            'comercial_id' => $clienteCom->cliente->user->id,
            'comercial_nombre' => $user->name . ' ' . $user->last_name,
            'fecha_contacto' => $request->get('fechaContacto'),
            'fecha_reunion' => $fechaReunion,
            'linkedin' => ($request->get('linkedin')) ? $request->get('linkedin') : 0,
            'envia_correo' => ($request->get('envioCorreo')) ? $request->get('envioCorreo') : 0,
            'respuesta' => ($request->get('respuesta')) ? $request->get('respuesta') : 0,
            'observaciones' => $request->get('observaciones'),
            'cliente_contacto_id' => $clienteContacto->id,
            'nombre_contacto' => $clienteContacto->nombre,
            'apellido_contacto' => $clienteContacto->apellido,
            'cargo_contacto' => $clienteContacto->cargo,
            'correo_contacto' => $clienteContacto->correo,
            'telefono_contacto' => $clienteContacto->telefono,
            'celular_contacto' => $clienteContacto->celular,
        ]);

        if ($clienteComunicacion->reunion_valida != 1) {
            $clienteComunicacion->fecha_reunion = ($request->get('fechaReunion')) ? $fechaReunion->format('Y-m-d H:i:00') : null;
        }

        if ($clienteComunicacion->isDirty()) {
            $clienteComunicacion->save();
        }

        if ($fechaRegistrada->ne($fechaFormulario)) {
            $clienteComunicacion->fecha_anterior = $fechaRegistrada->format('Y-m-d H:i:s');
            $adminPros = User::where(['rol_id' => 4])->orWhere(['id' => auth()->user()->id])->get();
            $mails = array();
            if ($adminPros) {
                foreach ($adminPros as $user) {
                    $mails[] = $user->email;
                }
            }

            if (count($mails) > 0) {
                retry(5, function () use ($clienteComunicacion, $mails) {
                    // Mail::to($mails)->send(new ReunionModificadaMail($clienteComunicacion));
                    Mail::to('dgonzalez@bcnschool.cl')->send(new ReunionModificadaMail($clienteComunicacion));
                }, 100);
            }
        }

        if ($request->calendario == 'calendario') {
            return redirect()->route('cliente-comunicacion.calendario')->with(['status' => 'Reunion modificada satisfactoriamente', 'title' => 'Éxito']);
        } else {
            return redirect()->route('cliente-comunicacion.conversacion', $clienteComunicacion->cliente_id)->with(['status' => 'Registro modificado satisfactoriamente', 'title' => 'Éxito']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClienteComunicacion  $clienteComunicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteComunicacion $clienteComunicacion)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function conversacion(Cliente $cliente, Request $request)
    {
        $comunicaciones = ClienteComunicacion::where(['cliente_id' => $cliente->id])->with(['tipoComunicacion'])->orderBy('created_at', 'desc')->get();
        $hoy = Carbon::today();

        $tipoComunicaciones = TipoComunicacion::where(['activo' => 1])->get();

        $contactos = $cliente->clienteContactos;

        auth()->user()->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Llamados y Reuniones', 'ruta' => route('cliente-comunicacion.index')], ['nombre' => 'Comunicaciones', 'ruta' => null]]);


        return view('pages.cliente_comunicacion.conversacion', compact('comunicaciones', 'cliente', 'hoy', 'tipoComunicaciones', 'contactos'));
    }

    public function validar(ClienteComunicacion $clienteComunicacion, Request $request)
    {

        $hoy = Carbon::now();
        $user = auth()->user();

        $clienteComunicacion->reunion_valida = 1;
        $clienteComunicacion->fecha_validacion = $hoy;
        $clienteComunicacion->usuario_validacion = $user->id;
        $clienteComunicacion->usuario_validacion_nombre = $user->name . ' ' . $user->last_name;

        $clienteComunicacion->save();

        return redirect()->route('cliente-comunicacion.conversacion', $clienteComunicacion->cliente_id)->with(['status' => 'Reunión validada satisfactoriamente', 'title' => 'Éxito']);
    }

    public function calendario()
    {
        $user = auth()->user();
        $hoy = Carbon::today();
        $active = 'calendario';
        if ($user->rol_id == 4) {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion', 'clienteContactos'])->get();
        } else {
            $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->whereHas('user', function ($sql) use ($user) {
                return $sql->where(['id_prospector' => $user->id]);
            })->with(['clienteComunicacion', 'clienteContactos'])->get();
        }
        // $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion'])->get();
        $tipoComunicaciones = TipoComunicacion::where(['activo' => 1])->get();

        $comunicaciones = ClienteComunicacion::with(['cliente'])->whereNotNull('fecha_reunion')->orderBy('fecha_contacto', 'DESC')->take(8)->get();

        $user->breadcrumbs = collect([['nombre' => 'Prospección', 'ruta' => null], ['nombre' => 'Calendario Reuniones', 'ruta' => null]]);


        return view('pages.cliente_calendario.index', compact('clientes', 'hoy', 'tipoComunicaciones', 'comunicaciones', 'active'));
    }

    public function reuniones(Request $request)
    {
        $fechaDesde = Carbon::parse($request->start);
        $desde = $fechaDesde->format('Y-m-d');
        $user = auth()->user();

        $fechaHasta = Carbon::parse($request->end);
        $hasta = $fechaHasta->format('Y-m-d');

        if ($user->rol_id == 5) {
            $reuniones = ClienteComunicacion::where(['prospector_id' => $user->id])->whereNotNull('fecha_reunion')->whereBetween('fecha_reunion', [$desde, $hasta])->with(['cliente'])->get();
        } else {
            $reuniones = ClienteComunicacion::whereNotNull('fecha_reunion')->whereBetween('fecha_reunion', [$desde, $hasta])->with(['cliente'])->get();
        }


        $arrReuniones = array();
        foreach ($reuniones as $reunion) {
            $arrReunion = [
                'title' => $reunion->cliente->razon_social,
                'start' => $reunion->fecha_reunion,
                'id' => $reunion->id,
                'color' => ($reunion->reunion_valida == 1) ? 'blue' : 'grey',
            ];
            array_push($arrReuniones, $arrReunion);
        }

        return response()->json($arrReuniones, 200);
    }

    public function calendarioStore(ClienteComunicacionRequest $request)
    {
        if ($request->get('fechaReunion') != '') {
            $rules = ['fechaReunion' => 'date|after_or_equal:fechaContacto', 'horaReunion' => 'required|date_format:H:i'];
            $customMessages = [
                'required' => 'El campo :attribute es requerido',
                'date' => 'El campo :attribute es una fecha inválida',
                'before_or_equal' => 'El campo :attribute debe ser mayor al campo Fecha Contacto'
            ];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('nuevoContacto') == 1) {

            if ($request->get('celularContacto') != '') {
                $rules = ['celularContacto' => 'starts_with:9|digits:9|numeric'];
                $customMessages = [
                    'starts_with' => 'El campo :attribute debe comenzar con el número 9',
                    'digits' => 'El campo :attribute debe tener :digits digítos',
                    'numeric' => 'El campo :attribute es inválido'
                ];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('fonoContacto') != '') {
                $rules = ['fonoContacto' => 'digits:9|numeric|starts_with:2'];
                $customMessages = [
                    'starts_with' => 'El campo :attribute debe comenzar con el número 2',
                    'digits' => 'El campo :attribute debe tener :digits digítos',
                    'numeric' => 'El campo :attribute es inválido'
                ];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('correoContacto') != '') {
                $rules = ['correoContacto' => 'email'];
                $customMessages = ['email' => 'El campo :attribute es inválido'];
                $this->validate($request, $rules, $customMessages);
            }

            if ($request->get('fonoContacto') == null && $request->get('correoContacto') == null && $request->get('celularContacto') == null) {
                return redirect()->route('cliente-comunicacion.index')->withInput()->withErrors([
                    'fonoContacto' => 'Debe seleccionar al menos una forma de contacto',
                    'celularContacto' => 'Debe seleccionar al menos una forma de contacto',
                    'correoContacto' => 'Debe seleccionar al menos una forma de contacto'
                ]);
            }

            $existe = ClienteContacto::where(['nombre' => $request->get('nombreContacto'), 'cliente_id' => $request->get('cliente')])
                ->where(function ($sql) use ($request) {
                    $sql->orWhere(['telefono' => $request->get('fonoContacto'), 'correo' => $request->get('correoContacto'), 'celular' => $request->get('celularContacto')]);
                })->first();

            if ($existe) {
                return redirect()->route('cliente-comunicacion.index')->withInput()->withErrors(
                    ['nombreContacto' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']
                );
            }

            $clienteContacto = ClienteContacto::create([
                'cliente_id' => $request->get('cliente'),
                'nombre' => $request->get('nombreContacto'),
                'apellido' => $request->get('apellidoContacto'),
                'cargo' => $request->get('cargoContacto'),
                'correo' => $request->get('correoContacto'),
                'telefono' => $request->get('fonoContacto'),
                'celular' => $request->get('celularContacto'),
            ]);
        } else {

            $rules = ['contactoId' => 'required|exists:cliente_contacto,id'];
            $customMessages = [
                'required' => 'Debe seleccionar un contacto o crear uno nuevo',
                'exists' => 'El campo :attribute es inválido'
            ];
            $this->validate($request, $rules, $customMessages);

            $clienteContacto = ClienteContacto::find($request->get('contactoId'));
        }

        $user = auth()->user();

        $stringFecha = $request->get('fechaReunion') . ' ' . $request->get('horaReunion');
        $fechaReunion = new Carbon($stringFecha);

        $cliente = Cliente::with(['user'])->find($request->get('cliente'));

        ClienteComunicacion::create([
            'cliente_id' => $request->get('cliente'),
            'tipo_comunicacion_id' => $request->get('tipoComunicacion'),
            'comercial_id' => $cliente->user->id,
            'comercial_nombre' => $cliente->user->name . ' ' . $cliente->user->last_name,
            'prospector_id' => $user->id,
            'prospector_nombre' => $user->name . ' ' . $user->last_name,
            'fecha_contacto' => $request->get('fechaContacto'),
            'fecha_reunion' => ($request->get('fechaReunion')) ? $fechaReunion->format('Y-m-d H:i:00') : null,
            'linkedin' => ($request->get('linkedin')) ? $request->get('linkedin') : 0,
            'envia_correo' => ($request->get('envioCorreo')) ? $request->get('envioCorreo') : 0,
            'respuesta' => ($request->get('respuesta')) ? $request->get('respuesta') : 0,
            'observaciones' => $request->get('observaciones'),
            'cliente_contacto_id' => $clienteContacto->id,
            'nombre_contacto' => $clienteContacto->nombre,
            'apellido_contacto' => $clienteContacto->apellido,
            'cargo_contacto' => $clienteContacto->cargo,
            'correo_contacto' => $clienteContacto->correo,
            'telefono_contacto' => $clienteContacto->telefono,
            'celular_contacto' => $clienteContacto->celular,

        ]);

        return redirect()->route('cliente-comunicacion.calendario')->with(['status' => 'Reunion creada satisfactoriamente', 'title' => 'Éxito']);
    }
}
