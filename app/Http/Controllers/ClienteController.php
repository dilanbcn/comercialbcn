<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use App\Models\Cliente;
use App\Models\TipoCliente;
use App\Models\User;
use Carbon\Carbon;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hoy = Carbon::now();
        $limite = $hoy->subMonths(8);

        $clientes = Cliente::where('inicio_ciclo', '>=', $limite->toDateTimeString())->with(['tipoCliente', 'padre', 'user'])->get();
        $clientes->map(function ($clientes) {
            $clientes->ciclo = $this->meses($clientes);
        });

        $groupCliente = $clientes->groupBy('activo');
        $arrEstados = array(0 => 'Inactivos', 1 => 'Activos');
        $arrGrupo = array('Activos' => 0, 'Inactivos' => 0);
        foreach ($groupCliente as $key => $cliente) {
            $arrGrupo[$arrEstados[$key]] = count($cliente);
        }

        return view('pages.cliente.index', compact('clientes', 'arrGrupo'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function prospectos()
    {
        $hoy = Carbon::now();
        $limite = $hoy->subMonths(8);

        $clientes = Cliente::where('inicio_ciclo', '<=', $limite->toDateTimeString())->with(['tipoCliente', 'padre', 'user'])->get();

        return view('pages.cliente.prospecto', compact('clientes'));
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

        return view('pages.cliente.create', compact('holdings', 'usuarios', 'tipoClientes'));
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
            'user_id' => ($user->rol_id == 2) ? $request->get('comercial') : $user->id,
            'tipo_cliente_id' => ($user->rol_id == 2) ? $request->get('tipo_cliente') : null,
            'padre_id' => $request->get('padre'),
            'rut' => Rut::parse($request->get('rut'))->number(),
            'razon_social' => $request->get('razon_social'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'direccion' => $request->get('direccion'),
            'inicio_ciclo' => $hoy,
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
        //
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

        $cliente->rut_format = ($cliente->rut) ? Rut::parse($cliente->rut)->format(Rut::FORMAT_WITH_DASH) : '';

        return view('pages.cliente.edit', compact('usuarios', 'holdings', 'cliente', 'tipoClientes'));
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

        $cliente->fill([
            'user_id' => ($user->rol_id == 2) ? $request->get('comercial') : $user->id,
            'padre_id' => $request->get('padre'),
            'rut' => Rut::parse($request->get('rut'))->number(),
            'razon_social' => $request->get('razon_social'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'direccion' => $request->get('direccion'),
            'activo' => ($request->activo) ? 1 : 0,
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
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return redirect()->route('cliente.index')->with(['title' => 'Exito', 'status' => 'Cliente eliminado satisfactoriamente']);
    }
}
