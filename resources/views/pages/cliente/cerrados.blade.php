@extends('layouts.app', [
'class' => '',
'elementActive' => 'cerrados'
])
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            @include('layouts.page_templates.messages')
            <div class="card">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <h5 class="card-title mb-1">Cerrados</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-striped tablaComercialesIndex">
                            <thead class="text-primary text-center">
                                <th>Estatus</th>
                                <th>Mes Cierre</th>
                                <th>Mes Facturación</th>
                                <th>Mes Pago</th>
                                <th>Cliente</th>
                                <th>Venta</th>
                                <th>Inscripción SENCE</th>
                                <th>Estatus</th>
                                <th>Comercial</th>
                                <th>Proyecto</th>
                            </thead>
                            <tbody>
                                @foreach($facturas as $key => $factura)
                                <tr class="text-center">
                                    <td>{{ $factura->proyecto->cliente->antiguedad }}</td>
                                    <td>{{ $factura->mes_cierre }}</td>
                                    <td>{{ $factura->mes_facturacion }}</td>
                                    <td>{{ $factura->mes_pago }}</td>
                                    <td class="text-left">{{ $factura->proyecto->cliente->razon_social }}</td>
                                    <td class="text-right">{{ number_format($factura->monto_venta, 0, ',', '.') }}</td>
                                    <td class="text-left">{{ $factura->inscripcion_sence }}</td>
                                    <td class="text-left">{{ $factura->estadoFactura->nombre }}</td>
                                    <td class="text-left">{{ $factura->proyecto->cliente->user->name . ' ' . $factura->proyecto->cliente->user->last_name }}</td>
                                    <td class="text-left">{{ $factura->proyecto->nombre }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.page_templates.form_delete')
@endsection