<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteComunicacionRequest;
use App\Models\Cliente;
use App\Models\ClienteComunicacion;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion'])->get();

        return view('pages.cliente_comunicacion.index', compact('clientes', 'hoy'));
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

        $user = auth()->user();

        $stringFecha = $request->get('fechaReunion') . ' ' . $request->get('horaReunion');
        $fechaReunion = new Carbon($stringFecha);

        ClienteComunicacion::create([
            'cliente_id' => $request->get('cliente'),
            'tipo_comunicacion' => ($request->get('tipoComunicacion')) ? ClienteComunicacion::LLAMADA : ClienteComunicacion::CORREO,
            'comercial_nombre' => $user->name . ' ' . $user->last_name,
            'fecha_contacto' => $request->get('fechaContacto'),
            'fecha_reunion' => ($request->get('fechaReunion')) ? $fechaReunion->format('Y-m-d H:i:00') : null,
            'linkedin' => ($request->get('linkedin')) ? $request->get('linkedin') : 0,
            'envia_correo' => ($request->get('envioCorreo')) ? $request->get('envioCorreo') : 0,
            'respuesta' => ($request->get('respuesta')) ? $request->get('respuesta') : 0,
            'observaciones' => $request->get('observaciones'),
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
        if ($request->get('fechaReunion') != '') {
            $rules = ['fechaReunion' => 'date|after_or_equal:fechaContacto', 'horaReunion' => 'required|date_format:H:i'];
            $customMessages = [
                'required' => 'El campo :attribute es requerido',
                'date' => 'El campo :attribute es una fecha inválida',
                'before_or_equal' => 'El campo :attribute debe ser mayor al campo Fecha Contacto',
                'date_format' => 'El campo :attribute es invádlido'
            ];
            $this->validate($request, $rules, $customMessages);
        }
        $user = auth()->user();

        $stringFecha = $request->get('fechaReunion') . ' ' . $request->get('horaReunion');
        $fechaReunion = new Carbon($stringFecha);

        $clienteComunicacion->fill([
            'tipo_comunicacion' => ($request->get('tipoComunicacion')) ? ClienteComunicacion::LLAMADA : ClienteComunicacion::CORREO,
            'comercial_nombre' => $user->name . ' ' . $user->last_name,
            'fecha_contacto' => $request->get('fechaContacto'),
            'fecha_reunion' => ($request->get('fechaReunion')) ? $fechaReunion->format('Y-m-d H:i:00') : null,
            'linkedin' => ($request->get('linkedin')) ? $request->get('linkedin') : 0,
            'envia_correo' => ($request->get('envioCorreo')) ? $request->get('envioCorreo') : 0,
            'respuesta' => ($request->get('respuesta')) ? $request->get('respuesta') : 0,
            'observaciones' => $request->get('observaciones'),
        ]);

        if ($clienteComunicacion->isDirty()) {
            $clienteComunicacion->save();
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
        $comunicaciones = ClienteComunicacion::where(['cliente_id' => $cliente->id])->orderBy('created_at', 'desc')->get()->groupBy('tipo_comunicacion');
        $hoy = Carbon::today();

        return view('pages.cliente_comunicacion.conversacion', compact('comunicaciones', 'cliente', 'hoy'));
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

        $hoy = Carbon::today();
        $clientes = Cliente::where(['tipo_cliente_id' => 2, 'activo' => 1])->with(['clienteComunicacion'])->get();

        return view('pages.cliente_calendario.index', compact('clientes', 'hoy'));
    }

    public function reuniones(Request $request)
    {
        $fechaDesde = Carbon::parse($request->start);
        $desde = $fechaDesde->format('Y-m-d');

        $fechaHasta = Carbon::parse($request->end);
        $hasta = $fechaHasta->format('Y-m-d');

        $reuniones = ClienteComunicacion::whereNotNull('fecha_reunion')->whereBetween('fecha_reunion', [$desde, $hasta])->with(['cliente'])->get();
        $arrReuniones = array();
        foreach($reuniones as $reunion){
            $arrReunion = [
                'title' => $reunion->cliente->razon_social,
                'start'=> $reunion->fecha_reunion,
                'id'=> $reunion->id,
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

        $user = auth()->user();

        $stringFecha = $request->get('fechaReunion') . ' ' . $request->get('horaReunion');
        $fechaReunion = new Carbon($stringFecha);

        ClienteComunicacion::create([
            'cliente_id' => $request->get('cliente'),
            'tipo_comunicacion' => ($request->get('tipoComunicacion')) ? ClienteComunicacion::LLAMADA : ClienteComunicacion::CORREO,
            'comercial_nombre' => $user->name . ' ' . $user->last_name,
            'fecha_contacto' => $request->get('fechaContacto'),
            'fecha_reunion' => ($request->get('fechaReunion')) ? $fechaReunion->format('Y-m-d H:i:00') : null,
            'linkedin' => ($request->get('linkedin')) ? $request->get('linkedin') : 0,
            'envia_correo' => ($request->get('envioCorreo')) ? $request->get('envioCorreo') : 0,
            'respuesta' => ($request->get('respuesta')) ? $request->get('respuesta') : 0,
            'observaciones' => $request->get('observaciones'),
        ]);

        return redirect()->route('cliente-comunicacion.calendario')->with(['status' => 'Reunion creada satisfactoriamente', 'title' => 'Éxito']);
    }

   
}
