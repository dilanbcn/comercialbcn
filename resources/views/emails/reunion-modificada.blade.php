<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Comerciales</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<style>
    #tableReunion td {
        border: 1px solid grey;
        padding: 0;
        height: 30px;
        padding-left: 5px;
    }
</style>

<body style="margin: 0; font-family: sans-serif;">
    <table border="0" align="center" cellpadding="0" cellspacing="0" style="width: 600px;">
        <tbody>
            <tr>
                <td>
                    <img src="{{ $url . '/paper/img/logo_bcn.png' }}" height="150px" alt="" />
                </td>
            </tr>
            <tr>
                <td width="200px" style="font-size: 18px; font-family: calibri; color: #706F6F; text-align: center;">
                    <table border="0" style="width: 600px;">
                        <tr>
                            <td>
                                <p style="font-size: 23px; text-align: left;">¡Hola!</p>
                                <p style="text-align: justify;">Se ha re-agendado una reunión</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table style="width: 100%;" id="tableReunion">
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">EMPRESA</td>
                                        <td style="text-align: left;">{{ $comunicacion->cliente->razon_social }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">CONTACTO</td>
                                        <td style="text-align: left;">{{ $comunicacion->nombre_contacto }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">TELÉFONO</td>
                                        <td style="text-align: left;">{{ $comunicacion->telefono_contacto }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">CELULAR</td>
                                        <td style="text-align: left;">{{ $comunicacion->celular_contacto }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">CORREO</td>
                                        <td style="text-align: left;">{{ $comunicacion->correo_contacto }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">FECHA ANTERIOR</td>
                                        <td style="text-align: left;">{{ date('d/m/Y H:i', strtotime($comunicacion->fecha_anterior)) }}</td>
                                    </tr>
                                    <tr style="background-color: #F9FF33;">
                                        <td style="font-weight: bold; text-align: left;">NUEVA FECHA</td>
                                        <td style="text-align: left;">{{ date('d/m/Y', strtotime($comunicacion->fecha_reunion)) }}</td>
                                    </tr>
                                    <tr  style="background-color: #F9FF33;">
                                        <td style="font-weight: bold; text-align: left;">NUEVA HORA</td>
                                        <td style="text-align: left;">{{ date('H:i', strtotime($comunicacion->fecha_reunion)) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">EJECUTIVA</td>
                                        <td style="text-align: left;">{{ $comunicacion->prospector_nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">VENDEDOR</td>
                                        <td style="text-align: left;">{{ $comunicacion->comercial_nombre }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold; text-align: left;">DIRECCIÓN</td>
                                        <td style="text-align: left;">{{ $comunicacion->cliente->direccion }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background-color:#6c757d; text-align:center; " height="20px; ">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>