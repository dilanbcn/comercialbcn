<html>
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

<table class="table table-striped">
    <tr class="text-center">
        <th align="center">Producto</th>
        <th colspan="3" align="center">Valores</th>
    </tr>
    <tbody>

        @foreach($arrCeldas as $celda)
        <tr>
            <td align="left">
                <ul>
                    <li style="font-weight: bold;">{{ $celda['nombre'] }}</li>
                    @if(array_key_exists('detalles', $celda))
                    @foreach($celda['detalles'] as $detalle)
                    <li>{{ $detalle }}</li>
                    @endforeach
                    @endif

                    @if(array_key_exists('observaciones', $celda))
                    <li>{{ $celda['observaciones'] }}</li>
                    @endif
                </ul>

            </td>
            @if(!$celda['rango'])
            <td colspan="3" align="center" style="vertical-align: middle">{{ $celda['valor'] }}</td>
            @else
            <td align="left">Rangos:</td>
            <td align="center">{{ $celda['valor_minimo'] }}</td>
            <td align="center">{{ $celda['valor_maximo'] }}</td>
            @endif
        </tr>
        @endforeach

        <tr>
            <td align="left">TOTAL</td>
            <td align="left">Rangos</td>
            <td align="center">{{ $arrTotales['total_minimo'] }}</td>
            <td align="center">{{ $arrTotales['total_maximo'] }}</td>
        </tr>

        <tr>
            <td>Inscripciones para levantamiento de fondos SENCE</td>
            <td align="left">Rangos</td>
            <td align="center">{{ $arrTotales['total_sence_min'] }}</td>
            <td align="center">{{ $arrTotales['total_sence_max'] }}</td>
        </tr>

        <tr>
            <td>Inscripciones e-learning recomendados por BCN</td>
            <td align="left">Rangos</td>
            <td align="center">{{ $arrTotales['total_bcn_min'] }}</td>
            <td align="center">{{ $arrTotales['total_bcn_max'] }}</td>
        </tr>
    </tbody>
</table>

</html>