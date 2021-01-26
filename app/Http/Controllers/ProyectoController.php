<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyectoRequest;
use App\Models\Cliente;
use App\Models\EstadoFactura;
use App\Models\Proyecto;
use App\Models\ProyectoFactura;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function clienteProyecto(Cliente $cliente)
    {
        $proyectos = Proyecto::where(['cliente_id' => $cliente->id])->get();

        return view('pages.proyecto.cliente-proyecto', compact('proyectos', 'cliente'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function proyectoFacrtura(Proyecto $proyecto)
    {
        $facturas = ProyectoFactura::where(['proyecto_id' => $proyecto->id])->get();
        $cliente = Cliente::find($proyecto->cliente_id);
        $estados = EstadoFactura::where(['activo' => 1])->get();

        return view('pages.proyecto.proyecto-factura', compact('proyecto', 'facturas', 'cliente', 'estados'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Cliente $cliente, ProyectoRequest $request)
    {
        Proyecto::create([
            'cliente_id' => $cliente->id,
            'nombre' => $request->get('nombre'),
            'fecha_cierre' => $request->get('fechaCierre')
        ]);

        $this->makeClient($cliente);

        return redirect()->route('proyecto.cliente-proyecto', [$cliente])->with(['status' => 'Proyecto creado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function show(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function edit(Proyecto $proyecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        //
    }
}
