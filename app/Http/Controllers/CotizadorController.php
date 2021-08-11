<?php

namespace App\Http\Controllers;

use App\Exports\CotizadorExport;
use App\Http\Requests\VentaRequest;
use App\Models\DetalleVenta;
use App\Models\TipoVenta;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CotizadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $ventas = Venta::with(['tipoVenta', 'detalleVentas'])->where(['estado' => 1])->get();

        $user->breadcrumbs = collect([['nombre' => 'Cotizador', 'ruta' => null]]);

        return view('pages.cotizador.index', compact('ventas'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAdmin()
    {
        $user = auth()->user();

        $user->breadcrumbs = collect([['nombre' => 'Cotizador', 'ruta' => null]]);

        return view('pages.cotizador.index_admin');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allAdmin()
    {
        $user = auth()->user();

        $productos = Venta::where('estado', 1)->get();

        $arrProductos = array();
        foreach ($productos as $producto) {
            $arrProductos[] = array(
                $producto->nombre,
                ($producto->estado) ? 'Activo' : 'Inactivo',
                $producto->id,
            );
        }

        $response = array('draw' => 1, 'recordsTotal' => count($arrProductos), 'recordsFiltered' => count($arrProductos), 'data' => $arrProductos);

        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {

        $venta = $venta->with(['tipoVenta', 'detalleVentas'])->find($venta->id);
        $tipoVenta = TipoVenta::all();

        $venta->chk_multiplicar = ($venta->multiplicar == 1) ? 'checked' : '';

        auth()->user()->breadcrumbs = collect([['nombre' => 'Cotizador', 'ruta' => route('cotizador.admin')], ['nombre' => 'Editar Detalle', 'ruta' => null]]);

        return view('pages.cotizador.detalle', compact('venta', 'tipoVenta'));
    }

    public function detalleEdit(DetalleVenta $detalleVenta)
    {

        $venta = Venta::find($detalleVenta->venta_id);

        $detalleVenta->tipo_venta_id = $venta->tipo_venta_id;
        $detalleVenta->valor_implementacion = ($detalleVenta->valor_implementacion) ? $this->decimalFormat($detalleVenta->valor_implementacion) : null;
        $detalleVenta->valor_mantencion = ($detalleVenta->valor_mantencion) ? $this->decimalFormat($detalleVenta->valor_mantencion) : null;
        $detalleVenta->precio = ($detalleVenta->precio) ? $this->decimalFormat($detalleVenta->precio) : null;
        $detalleVenta->precio_minimo = ($detalleVenta->precio_minimo) ? $this->decimalFormat($detalleVenta->precio_minimo) : null;
        $detalleVenta->precio_maximo = ($detalleVenta->precio_maximo) ? $this->decimalFormat($detalleVenta->precio_maximo) : null;
        $detalleVenta->success = 'ok';

        return response()->json($detalleVenta, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VentaRequest $request, Venta $venta)
    {
        $venta->nombre = $request->get('nombre');
        $venta->precio_base = ($request->has('precio_base')) ? $this->decimalFormatBD($request->get('precio_base')) : null;

        if ($venta->mostrar_extra == 1) {

            $venta->descripcion_extra = ($request->has('descripcion_extra')) ? $request->get('descripcion_extra') : null;
            $venta->precio_extra = ($request->has('precio_extra')) ? $this->decimalFormatBD($request->get('precio_extra')) : null;
        }

        if ($venta->valor_multiplicar == 1) {

            $venta->multiplicar = ($request->has('multiplicar')) ? true : false;
        }

        $venta->save();

        return redirect()->route('cotizador.edit',  $venta->id)->with(['status' => 'Producto modificado satisfactoriamente', 'title' => 'Éxito']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detalleUpdate(Request $request, DetalleVenta $detalleVenta)
    {

        switch ($request->get('tipo_venta')) {

            case 1:
                $detalleVenta->valor_implementacion = $this->decimalFormatBD($request->get('inp_valor_implementacion'));
                $detalleVenta->valor_mantencion = $this->decimalFormatBD($request->get('inp_valor_mantencion'));
                break;
            case 2:
                $detalleVenta->precio = $this->decimalFormatBD($request->get('inp_precio'));
                break;
            case 3:
                $precioMinimo = $this->decimalFormatBD($request->get('inp_precio_minimo'));
                $precioMaximo = ($request->has('inp_precio_maximo')) ? $this->decimalFormatBD($request->get('inp_precio_maximo')) : null;

                $detalleVenta->precio_minimo = $precioMinimo;
                $detalleVenta->precio_maximo = ($precioMaximo) ? $precioMaximo : null;
                break;
        }

        $detalleVenta->save();

        return redirect()->route('cotizador.edit',  $detalleVenta->venta_id)->with(['status' => 'Detalle modificado satisfactoriamente', 'title' => 'Éxito']);
    }

    public function generar(Request $request)
    {

        $ventas = Venta::where(['estado' => 1])->get();
        $arrCeldas = array();
        $precioAlumno = 480000;
        $totalMinimo = 0;
        $totalMaximo = 0;

        foreach ($ventas as $venta) {

            $sumaVenta = null;
            $sumaVentaMin = null;
            $sumaVentaMax = null;

            if ($venta->tipo_venta_id == 1) {

                // SUMAR EL VALOR IMPLEMENTACION Y EL VALOR MANTENCION
                if ($request->has('opt_radio_rango_' . $venta->id)) {

                    $arrCeldas[$venta->id]['rango'] = false;
                    $arrCeldas[$venta->id]['nombre'] = $venta->nombre;

                    $rango = $request->get('opt_radio_rango_' . $venta->id);

                    $detalleVenta = DetalleVenta::find($rango);

                    $sumaVenta = $detalleVenta->valor_implementacion + $detalleVenta->valor_mantencion;

                    // EXTRA
                    if ($request->has('precio_extra_' . $venta->id)) {

                        $sumaVenta += $request->get('precio_extra_' . $venta->id);
                    }

                    $arrCeldas[$venta->id]['valor'] = number_format($sumaVenta, 0, ',', '.');

                    $totalMinimo += $sumaVenta;
                    $totalMaximo += $sumaVenta;

                    // OBSERVACIONES
                    if ($request->has('observaciones_' . $venta->id)) {

                        $arrCeldas[$venta->id]['observaciones'] = $request->get('observaciones_' . $venta->id);
                    }
                }
            } else {

                if ($request->has('opt_radio_' . $venta->id)) {

                    $arrCeldas[$venta->id]['nombre'] = $venta->nombre;

                    $detalle = $request->get('opt_radio_' . $venta->id);

                    if ($venta->excluyente == 1) {

                        $detalleVenta = DetalleVenta::where(['id' => $detalle])->get();
                    } else {
                        $detalleVenta = DetalleVenta::where(['venta_id' => $venta->id])->get();
                    }

                    foreach ($detalleVenta as $detalle) {

                        if ($request->has('cant_precio_det_' . $detalle->id)) {

                            $arrCeldas[$venta->id]['detalles'][] = $detalle->descripcion_tipo_precio . ': ' . $request->get('cant_precio_det_' . $detalle->id);


                            if ($venta->tipo_venta_id == 3) {
                                if ($detalle->precio_maximo) {
                                    $sumaVentaMin += $detalle->precio_minimo * $request->get('cant_precio_det_' . $detalle->id);
                                    $sumaVentaMax += $detalle->precio_maximo * $request->get('cant_precio_det_' . $detalle->id);
                                } else {
                                    $sumaVentaMin += $detalle->precio * $request->get('cant_precio_det_' . $detalle->id);
                                    $sumaVentaMax += $detalle->precio * $request->get('cant_precio_det_' . $detalle->id);
                                }
                            } else {
                                $sumaVenta += $detalle->precio * $request->get('cant_precio_det_' . $detalle->id);
                            }
                        } else {

                            if ($venta->excluyente == 1) {
                                $arrCeldas[$venta->id]['detalles'][] = $detalle->descripcion_tipo_precio;
                                if ($venta->tipo_venta_id == 3) {
                                    $sumaVentaMin += $detalle->precio + $detalle->precio_minimo;
                                    $sumaVentaMax += $detalle->precio + $detalle->precio_maximo;
                                } else {
                                    $sumaVenta += $detalle->precio;
                                }
                            }
                        }
                    }



                    if ($request->has('cant_vend_' . $venta->id)) {
                        if ($request->get('cant_vend_' . $venta->id) != null) {
                            $sumaVentaMin *= $request->get('cant_vend_' . $venta->id);
                            $sumaVentaMax *= $request->get('cant_vend_' . $venta->id);
                            $sumaVenta *= $request->get('cant_vend_' . $venta->id);
                        }
                    }



                    if ($venta->tipo_venta_id == 3) {
                        $arrCeldas[$venta->id]['rango'] = true;
                        // EXTRA
                        if ($request->has('precio_extra_' . $venta->id)) {
                            $sumaVentaMin += $request->get('precio_extra_' . $venta->id);
                            $sumaVentaMax += $request->get('precio_extra_' . $venta->id);
                        }
                        // EXTRA
                        if ($venta->precio_base > 0) {


                            $sumaVentaMin += $venta->precio_base;
                            $sumaVentaMax += $venta->precio_base;
                        }
                        // echo "3:".$sumaVentaMin.' --'.$sumaVentaMax.' + '.$venta->precio_base.'<br>';

                    } else {
                        $arrCeldas[$venta->id]['rango'] = false;
                        // EXTRA
                        if ($request->has('precio_extra_' . $venta->id)) {
                            $sumaVenta += $request->get('precio_extra_' . $venta->id);
                        }

                        // EXTRA
                        if ($venta->precio_base > 0) {
                            $sumaVenta += $venta->precio_base;
                        }
                    }


                    $arrCeldas[$venta->id]['valor'] = number_format($sumaVenta, 0);
                    $arrCeldas[$venta->id]['valor_minimo'] = number_format($sumaVentaMin, 0);
                    $arrCeldas[$venta->id]['valor_maximo'] = number_format($sumaVentaMax, 0);

                    $totalMinimo += $sumaVenta + $sumaVentaMin;
                    $totalMaximo += $sumaVenta + $sumaVentaMax;
                }
            }
        }

        $totalSenceMin = $totalMinimo / $precioAlumno;
        $totalSenceMax = $totalMaximo / $precioAlumno;

        $totalBcnMin = $totalSenceMin * 2;
        $totalBcnMax = $totalSenceMax * 2;

        $arrTotales['total_minimo'] = number_format($totalMinimo, 0);
        $arrTotales['total_maximo'] = number_format($totalMaximo, 0);

        $arrTotales['total_sence_min'] = number_format($totalSenceMin, 0);
        $arrTotales['total_sence_max'] = number_format($totalSenceMax, 0);

        $arrTotales['total_bcn_min'] = number_format($totalBcnMin, 0);
        $arrTotales['total_bcn_max'] = number_format($totalBcnMax, 0);

        $hoy = Carbon::now();

        $ventas = Venta::where('estado', 1)->get();

        $nombreArchivo = 'cotizador-bcn-' . $hoy->format('YmdHi') . '.xlsx';

        $celdas = 'A2:D' . (count($arrCeldas) + 4);

        $celdas_totales = 'A' . (count($arrCeldas) + 2) . ':D' . (count($arrCeldas) + 4);

        $data = compact('arrCeldas', 'celdas', 'arrTotales', 'celdas_totales');
        return Excel::download(new CotizadorExport($data), $nombreArchivo);
    }
}
