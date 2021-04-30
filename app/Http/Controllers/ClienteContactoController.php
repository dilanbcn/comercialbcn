<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteContactoRequest;
use App\Models\Cliente;
use App\Models\ClienteContacto;
use Illuminate\Http\Request;

class ClienteContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cliente $cliente)
    {
        
        $contactos = ClienteContacto::with(['cliente'])->where(['cliente_id' => $cliente->id])->get();

        auth()->user()->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Clientes General', 'ruta' => route('cliente.index')], ['nombre' => 'Contactos', 'ruta' => null]]);


        return view('pages.cliente_contacto.index', compact('contactos', 'cliente'));
    }

    public function json(Cliente $cliente)
    {
        $contactos = ClienteContacto::with(['cliente'])->where(['cliente_id' => $cliente->id])->get();

        return response()->json($contactos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Cliente $cliente)
    {
        return view('pages.cliente_contacto.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Cliente $cliente, ClienteContactoRequest $request)
    {

        if ($request->get('celular') != '') {
            $rules = ['celular' => 'starts_with:9|digits:9|numeric'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 9', 
                'digits' => 'El campo :attribute debe tener :digits digítos', 
                'numeric' => 'El campo :attribute es inválido'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != '') {
            $rules = ['email' => 'email|confirmed'];
            $customMessages = ['email' => 'El campo :attribute es inválido', 'confirmed' => 'El correo no coincide'];
            $this->validate($request, $rules, $customMessages);
        }

        ClienteContacto::create([
            'cliente_id' => $cliente->id,
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'cargo' => $request->get('cargo'),
            'correo' => $request->get('email'),
            'telefono' => $request->get('telefono'),
            'celular' => $request->get('celular'),
        ]);

        return redirect()->route('cliente-contacto.index', [$cliente])->with(['status' => 'Contacto creado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClienteContacto  $clienteContacto
     * @return \Illuminate\Http\Response
     */
    public function show(ClienteContacto $clienteContacto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClienteContacto  $clienteContacto
     * @return \Illuminate\Http\Response
     */
    public function edit(ClienteContacto $clienteContacto)
    {
        $clienteContacto->success = 'ok';

        return response()->json($clienteContacto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClienteContacto  $clienteContacto
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteContactoRequest $request, ClienteContacto $clienteContacto)
    {
        if ($request->get('celular') != '') {
            $rules = ['celular' => 'starts_with:9|digits:9|numeric'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 9', 
                'digits' => 'El campo :attribute debe tener :digits digítos', 
                'numeric' => 'El campo :attribute es inválido'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'digits:9|numeric|starts_with:2'];
            $customMessages = [
                'starts_with' => 'El campo :attribute debe comenzar con el número 2', 
                'digits' => 'El campo :attribute debe tener :digits digítos', 
                'numeric' => 'El campo :attribute es inválido'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('email') != '') {
            $rules = ['email' => 'email|confirmed'];
            $customMessages = ['email' => 'El campo :attribute es inválido', 'confirmed' => 'El correo no coincide'];
            $this->validate($request, $rules, $customMessages);
        }

        $cliente = $clienteContacto->cliente;

        $clienteContacto->fill([
            'nombre' => $request->get('nombre'),
            'apellido' => $request->get('apellido'),
            'cargo' => $request->get('cargo'),
            'telefono' => $request->get('telefono'),
            'celular' => $request->get('celular'),
            'correo' => $request->get('email'),
            'activo' => ($request->activo) ? 1 : 0,
        ]);

        if ($clienteContacto->isDirty()) {
            $clienteContacto->save();
        }

        return redirect()->route('cliente-contacto.index', [$cliente])->with(['status' => 'Contacto modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClienteContacto  $clienteContacto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClienteContacto $clienteContacto)
    {
        $cliente = $clienteContacto->cliente;

        $clienteContacto->delete();

        return redirect()->route('cliente-contacto.index', [$cliente])->with(['status' => 'Contacto eliminado satisfactoriamente', 'title' => 'Éxito']);
    }
}
