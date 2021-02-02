<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteContactoRequest;
use App\Models\Cliente;
use App\Models\ClienteContacto;
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
        $contactos = ClienteContacto::with(['cliente' => function ($sql) {
            return $sql->with(['tipoCliente', 'padre', 'user']);
        }])->whereHas('cliente', function ($sql) {
            $sql->where(['activo' => true]);
        })->get();

        $clientes = Cliente::where(['activo' => 1])->get();

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
                'numeric' => 'El campo :attribute es inválido'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'digits:9|numeric|starts_with:2'];
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

        if ($request->get('telefono') == null && $request->get('email') == null && $request->get('celular') == null) {
            return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                ['telefono' => 'Debe seleccionar al menos una forma de contacto', 'celular' => 'Debe seleccionar al menos una forma de contacto', 'email' => 'Debe seleccionar al menos una forma de contacto']);
        }

        $existe = ClienteContacto::where(['nombre' => $request->get('nombre'), 'cliente_id' => $request->get('cliente')])
        ->where(function($sql) use($request){
            $sql->orWhere(['telefono' => $request->get('telefono'), 'correo' => $request->get('correo'), 'celular' => $request->get('celular')]);
        })->first();

        if ($existe) {
            return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                ['nombre' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']);
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
                'numeric' => 'El campo :attribute es inválido'];
            $this->validate($request, $rules, $customMessages);
        }

        if ($request->get('telefono') != '') {
            $rules = ['telefono' => 'digits:9|numeric|starts_with:2'];
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

        if ($request->get('telefono') == null && $request->get('email') == null && $request->get('celular') == null) {
            return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                ['telefono' => 'Debe seleccionar al menos una forma de contacto', 'celular' => 'Debe seleccionar al menos una forma de contacto', 'email' => 'Debe seleccionar al menos una forma de contacto']);
        }

        if ($request->get('cliente') != $clienteContacto->cliente_id){
            $existe = ClienteContacto::where(['nombre' => $request->get('nombre'), 'cliente_id' => $request->get('cliente')])
            ->where(function($sql) use($request){
                $sql->orWhere(['telefono' => $request->get('telefono'), 'correo' => $request->get('correo'), 'celular' => $request->get('celular')]);
            })->first();
    
            if ($existe) {
                return redirect()->route('prospeccion.contactos')->withInput()->withErrors(
                    ['nombre' => 'Ya existe un contacto con ese nombre para el cliente seleccionado']);
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
}
