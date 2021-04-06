<!DOCTYPE html>
<html>

<head>
    <title>Clientes General</title>
</head>
<style>
    html {
        font-family: sans-serif;
        line-height: 1.15;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
        -webkit-tap-highlight-color: transparent;
    }

    .table .table {
        background-color: #fff;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    table {
        border-collapse: collapse;
    }

    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, .05);
    }

    .table td,
    .table th {
        padding: .75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    th {
        text-align: inherit;
    }

    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td {
        padding: 12px 7px;
        vertical-align: middle;
    }

    .pl-5,
    .px-5 {
        padding-left: 3rem !important;
    }

    .text-center {
        text-align: center !important;
    }

    .card .card-header .card-title {
        margin-top: 10px;
    }

    .mb-1,
    .my-1 {
        margin-bottom: .25rem !important;
    }

    h5,
    .h5 {
        font-size: 1.57em;
        line-height: 1.4em;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-weight: 400;
        font-family: inherit;
    }

    .card-category {
        font-size: 1em;
    }

    .category,
    .card-category {
        font-weight: 400;
        color: #75777B;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }
</style>

<body>
    <div class="col-md-12">
        <div class="card">
            @if ($tipo == 3)
            <div class="card-header">
                <table class="table">
                    <tr>
                        <td class="text-left" style="border-top: none !important;">
                            <h5 class="card-title mb-1">Clientes General</h5>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="card-body">
                <div class="table">
                    <table class="table table-striped" style="margin-top: 30px;">
                        <tr class="text-center" style="background-color: #D2E9FF;">
                            <th>Holding</th>
                            <th>Cliente</th>
                            <th>Comercial</th>
                            <th>Tipo</th>
                            <th>Inicio Ciclo</th>
                            <th>Ciclo 8 Meses</th>
                        </tr>
                        <tbody>
                            @foreach($clientes as $key => $cliente)
                            <tr>
                                <td class="text-left">{{ ($cliente->padre != null) ? $cliente->padre->razon_social : '' }}</td>
                                <td class="text-left">{{ $cliente->razon_social }}</td>
                                <td class="text-left">{{ $cliente->user->name . ' ' . $cliente->user->last_name }}</td>
                                <td class="text-center">{{ $cliente->tipoCliente->nombre }}</td>
                                <td class="text-center">{{ ($cliente->tipo_cliente_id == 1) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '' }}</td>
                                <td class="text-center">{{ ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @if ($tipo == 4)
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td colspan="4" style="font-weight: bold; text-align:left; font-size:14ex">Clientes General </td>
                    </tr>
                    <tr class="d-flex border text-center">
                        <th class="border-right" style="font-weight: bold; text-align:center;" bgcolor="#dee2e6" width="40" height="20">Holding</th>
                        <th class="border-right" style="font-weight: bold; text-align:center;" bgcolor="#dee2e6" width="40" height="20">Cliente</th>
                        <th class="border-right" style="font-weight: bold; text-align:center;" bgcolor="#dee2e6" width="40" height="20">Comercial</th>
                        <th class="border-right" style="font-weight: bold; text-align:center;" bgcolor="#dee2e6" width="15" height="20">Tipo</th>
                        <th class="border-right" style="font-weight: bold; text-align:center;" bgcolor="#dee2e6" width="20" height="20">Inicio Ciclo</th>
                        <th class="border-right" style="font-weight: bold; text-align:center;" bgcolor="#dee2e6" width="20" height="20">Ciclo 8 Meses</th>
                    </tr>
                    @foreach($clientes as $key => $cliente)
                    <tr class="d-flex border">
                        <td class="border-right" style="text-align:left; vertical-align:middle;">{{ ($cliente->padre != null) ? $cliente->padre->razon_social : '' }}</td>
                        <td class="border-right" style="text-align:left; vertical-align:middle;">{{ $cliente->razon_social }}</td>
                        <td class="border-right" style="text-align:left; vertical-align:middle;">{{ $cliente->user->name . ' ' . $cliente->user->last_name }}</td>
                        <td class="border-right" style="text-align:center; vertical-align:middle;">{{ $cliente->tipoCliente->nombre }}</td>
                        <td class="border-right" style="text-align:center; vertical-align:middle;">{{ ($cliente->tipo_cliente_id == 1) ? date('d/m/Y', strtotime($cliente->inicio_ciclo)) : '' }}</td>
                        <td class="border-right" style="text-align:center; vertical-align:middle;">{{ ($cliente->tipo_cliente_id == 1) ? $cliente->ciclo : '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</body>

</html>