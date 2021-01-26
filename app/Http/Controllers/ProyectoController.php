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
        $proyecto->success = 'ok';

        return response()->json($proyecto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function update(ProyectoRequest $request, Proyecto $proyecto)
    {
        $cliente = $proyecto->cliente;

        $proyecto->fill([
            'nombre' => $request->get('nombre'),
            'fecha_cierre' => $request->get('fechaCierre'),
        ]);

        if ($proyecto->isDirty()) {
            $proyecto->save();
        }

        return redirect()->route('proyecto.cliente-proyecto', [$cliente])->with(['status' => 'Proyecto modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        $cliente = $proyecto->cliente;
        ProyectoFactura::where(['proyecto_id' => $proyecto->id])->delete();
        $proyecto->delete();

        $this->makeProspect($cliente);

        return redirect()->route('proyecto.cliente-proyecto', [$cliente])->with(['status' => 'Proyecto eliminado satisfactoriamente', 'title' => 'Éxito']);
    }
}
