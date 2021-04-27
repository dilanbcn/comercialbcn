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
        $proyectos = Proyecto::where(['cliente_id' => $cliente->id])->with(['proyectoFacturas'])->withCount(['proyectoFacturas'])->get();
        $estados = EstadoFactura::where(['activo' => 1])->get();

        $nombreComercial = ($cliente->externo) ? $cliente->user->name . ' ' . $cliente->user->last_name . " " . $cliente->externo : $cliente->user->name . ' ' . $cliente->user->last_name;
        $nombreComercial = ($cliente->compartido) ? $nombreComercial . ' / ' . $cliente->compartido->name . ' ' . $cliente->compartido->last_name : $nombreComercial;

        $cliente->nombre_comercial = $nombreComercial;

        auth()->user()->breadcrumbs = collect([['nombre' => 'Clientes', 'ruta' => null], ['nombre' => 'Clientes General', 'ruta' => route('cliente.index')], ['nombre' => 'Tickets', 'ruta' => null]]);

        return view('pages.proyecto.cliente-proyecto', compact('proyectos', 'cliente', 'estados'));
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
    public function proyectosJson(Request $request)
    {

        $termino = $request->search . '%';
        $proyectos = Proyecto::where('nombre', 'LIKE', $termino)->distinct('nombre')->pluck('nombre');


        return  $proyectos->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Cliente $cliente, ProyectoRequest $request)
    {

        $rules = ['fechaFacturacion' => 'after_or_equal:' . $request->get('fechaCierre')];
        $customMessages = ['after_or_equal' => 'Debe ser mayor o igual que la fecha de cierre (' .  date('d/m/Y', strtotime($request->get('fechaCierre'))) . ')'];

        $this->validate($request, $rules, $customMessages);

        $user = auth()->user();


        $proyecto = Proyecto::create([
            'cliente_id' => $cliente->id,
            'nombre' => $request->get('nombre'),
            'fecha_cierre' => $request->get('fechaCierre'),
            'updated_by' => $user->id
        ]);

        $this->makeClient($cliente);


        ProyectoFactura::create([
            'proyecto_id' => $proyecto->id,
            'estado_factura_id' => $request->get('estado'),
            'inscripcion_sence' => $request->get('inscripcionSence'),
            'fecha_factura' => $request->get('fechaFacturacion'),
            // 'fecha_pago' => $request->get('fechaPago'),
            'monto_venta' => $this->decimalFormatBD($request->get('montoVenta')),
        ]);


        return redirect()->route('proyecto.cliente-proyecto', [$cliente])->with(['status' => 'Ticket creado satisfactoriamente', 'title' => 'Éxito']);
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

        $proyectos = $proyecto->with('proyectoFacturas')->find($proyecto->id);
        $proyectos->proyectoFacturas->monto_venta = $this->decimalFormat($proyectos->proyectoFacturas->monto_venta);
        $proyectos->success = 'ok';

        return response()->json($proyectos, 200);
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

        $rules = ['fechaFacturacion' => 'after_or_equal:' . $proyecto->fecha_cierre];
        $customMessages = ['after_or_equal' => 'Debe ser mayor o igual que la fecha de cierre (' .  date('d/m/Y', strtotime($proyecto->fecha_cierre)) . ')'];
        $this->validate($request, $rules, $customMessages);


        $cliente = $proyecto->cliente;
        $user = auth()->user();

        if ($user->id != $cliente->user_id && ($user->rol_id == 1 || $user->rol_id == 3)) {
            return redirect()->route('proyecto.cliente-proyecto', $cliente)->withInput()->withErrors([
                'razon_social' => 'Imposible modificar datos de un cliente que no le pertenece',
            ]);
        }

        $proyecto->fill([
            'nombre' => $request->get('nombre'),
            'fecha_cierre' => $request->get('fechaCierre'),
            'updated_by' => $user->id
        ]);

        if ($proyecto->isDirty()) {
            $proyecto->save();
        }

        $proyectoFactura = ProyectoFactura::where(['proyecto_id' => $proyecto->id])->first();

        $proyectoFactura->fill([
            'estado_factura_id' => $request->get('estado'),
            'inscripcion_sence' => $request->get('inscripcionSence'),
            'fecha_factura' => $request->get('fechaFacturacion'),
            // 'fecha_pago' => $request->get('fechaPago'),
            'monto_venta' => $this->decimalFormatBD($request->get('montoVenta')),
        ]);

        if ($proyectoFactura->isDirty()) {
            $proyectoFactura->save();
        }

        return redirect()->route('proyecto.cliente-proyecto', [$cliente])->with(['status' => 'Ticket modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proyecto  $proyecto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proyecto $proyecto)
    {
        $user = auth()->user();

        $cliente = $proyecto->cliente;
        ProyectoFactura::where(['proyecto_id' => $proyecto->id])->delete();

        $proyecto->updated_by = $user->id;
        $proyecto->delete();

        $this->makeProspect($cliente);

        return redirect()->route('proyecto.cliente-proyecto', [$cliente])->with(['status' => 'Ticket eliminado satisfactoriamente', 'title' => 'Éxito']);
    }
}
