<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sistema de Comerciales</title>
    <!-- fuente -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

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
                                <p style="margin-top: 40px">¡Error en el Sistema de Comerciales!</p>
                                <p style="font-size: 23px; margin-top: 40px; text-align: left;">¡Hola!</p>
                                <p style="margin-top: 40px">Se ha presentado un error en el sistema:</p>
                            </td>
                        </tr>
                        <tr style="text-align: left;">
                            <td>
                            {{ 'Error: '. $exception->getMessage() }}
                            </td>
                        </tr>
                        <tr style="text-align: left;">
                            <td>
                            {{ 'Código: '.$exception->getCode() }}
                            </td>
                        </tr>
                        <tr style="text-align: left;">
                            <td>
                            {{ 'Archivo: '.$exception->getFile() }}
                            </td>
                        </tr>
                        <tr style="text-align: left;">
                            <td>
                            {{ 'Linea: '.$exception->getLine() }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background-color:#35D32F; text-align:center;" height="20px;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</body>

</html>