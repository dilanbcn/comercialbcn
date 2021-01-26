<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProyectoFacturaRequest;
use App\Models\Cliente;
use App\Models\EstadoFactura;
use App\Models\Proyecto;
use App\Models\ProyectoFactura;
use Illuminate\Http\Request;

class ProyectoFacturaController extends Controller
{
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

        return view('pages.factura.proyecto-factura', compact('proyecto', 'facturas', 'cliente', 'estados'));
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
    public function store(ProyectoFacturaRequest $request, Proyecto $proyecto)
    {
        $rules = ['fechaFacturacion' => 'after_or_equal:' . $proyecto->fecha_cierre];
        $customMessages = ['after_or_equal' => 'Debe ser mayor o igual que la fecha del proyecto (' .  date('d/m/Y', strtotime($proyecto->fecha_cierre)) . ')'];
        $this->validate($request, $rules, $customMessages);

        ProyectoFactura::create([
            'proyecto_id' => $proyecto->id,
            'estado_factura_id' => $request->get('estado'),
            'inscripcion_sence' => $request->get('inscripcionSence'),
            'fecha_factura' => $request->get('fechaFacturacion'),
            'fecha_pago' => $request->get('fechaPago'),
            'monto_venta' => $this->decimalFormatBD($request->get('montoVenta')),
        ]);

        return redirect()->route('factura.proyecto-factura', [$proyecto])->with(['status' => 'Factura creada satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProyectoFactura  $proyectoFactura
     * @return \Illuminate\Http\Response
     */
    public function show(ProyectoFactura $proyectoFactura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProyectoFactura  $proyectoFactura
     * @return \Illuminate\Http\Response
     */
    public function edit(ProyectoFactura $proyectoFactura)
    {

        $proyectoFactura->success = 'ok';
        $proyectoFactura->monto_venta = $this->decimalFormat($proyectoFactura->monto_venta);

        return response()->json($proyectoFactura, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProyectoFactura  $proyectoFactura
     * @return \Illuminate\Http\Response
     */
    public function update(ProyectoFacturaRequest $request, ProyectoFactura $proyectoFactura)
    {
        $proyecto = $proyectoFactura->proyecto;

        $rules = ['fechaFacturacion' => 'after_or_equal:' . $proyecto->fecha_cierre];
        $customMessages = ['after_or_equal' => 'Debe ser mayor o igual que la fecha del proyecto (' .  date('d/m/Y', strtotime($proyecto->fecha_cierre)) . ')'];
        $this->validate($request, $rules, $customMessages);

        $proyectoFactura->fill([
            'estado_factura_id' => $request->get('estado'),
            'inscripcion_sence' => $request->get('inscripcionSence'),
            'fecha_factura' => $request->get('fechaFacturacion'),
            'fecha_pago' => $request->get('fechaPago'),
            'monto_venta' => $this->decimalFormatBD($request->get('montoVenta')),
        ]);

        if ($proyectoFactura->isDirty()) {
            $proyectoFactura->save();
        }

        return redirect()->route('factura.proyecto-factura', [$proyecto])->with(['status' => 'Factura modificada satisfactoriamente', 'title' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProyectoFactura  $proyectoFactura
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProyectoFactura $proyectoFactura)
    {
        $proyecto = $proyectoFactura->proyecto;

        $proyectoFactura->delete();

        return redirect()->route('factura.proyecto-factura', [$proyecto])->with(['status' => 'Factura eliminada satisfactoriamente', 'title' => 'Éxito']);
    }
}
