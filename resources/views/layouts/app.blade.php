<!--
=========================================================
 Paper Dashboard - v2.0.0
=========================================================

 Product Page: https://www.creative-tim.com/product/paper-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 UPDIVISION (https://updivision.com)
 Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('paper/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('paper/img/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <!-- Extra details for Live View on GitHub Pages -->

    <title>
        {{ __('Comercial') }}
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="{{ asset('paper/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('paper/css/paper-dashboard.css?v=2.0.0') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('paper/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('paper/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('paper/css/jquery-confirm.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('paper/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('paper/css/submit.css') }}" rel="stylesheet" />
    <!-- Data Tables -->
    <link rel="stylesheet" type="text/css" href="{{ asset('paper/css/datatables.min.css') }}" />
    <!-- Toast -->
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('paper/css/jquery.toast.min.css') }}"/> -->
    <link rel="stylesheet" type="text/css" href="{{ asset('paper/css/toastr.min.css') }}" />
    <!-- CharJs -->
    <link href="{{ asset('paper/css/chartjs/Chart.min.css') }}" rel="stylesheet" />

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.5.1/main.css' rel='stylesheet' />
    <!-- Data Table -->
    <link href='https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css' rel='stylesheet' />
    <link href='https://cdn.datatables.net/buttons/1.7.0/css/buttons.bootstrap4.min.css' rel='stylesheet' />
    <link href="{{ asset('paper/css/rowGroup.dataTables.css') }}" rel="stylesheet" />
    <link href="{{ asset('paper/css/responsive.dataTables.css') }}" rel="stylesheet" />

    <!-- jQuery UI 
    <link href="{{ asset('paper/css/jquery-ui.1.12.1.css') }}" rel="stylesheet" />-->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



</head>

<body class="{{ $class }}">

    @auth()
    @include('layouts.page_templates.auth')
    @include('layouts.page_templates.modal_cambio_pass')
    @endauth

    @guest
    @include('layouts.page_templates.guest')
    @endguest


    <!--   Core JS Files   -->
    <script src="{{ asset('paper/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('paper/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('paper/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('paper/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('paper/js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('paper/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('paper/js/paper-dashboard.min.js?v=2.0.0') }}" type="text/javascript"></script>

    <script src="{{ asset('paper/js/plugins/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('paper/js/plugins/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('paper/js/comercial.js') }}"></script>
    <script src="{{ asset('paper/js/combos.js') }}"></script>
    <script src="{{ asset('paper/js/graficos.js') }}"></script>
    <script src="{{ asset('paper/js/submit.js') }}"></script>
    <script src="{{ asset('paper/js/plugins/bootstrap-select.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/00c104946b.js" crossorigin="anonymous"></script>

    <!-- Data Tables -->
    <script type="text/javascript" src="{{ asset('paper/js/datatables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('paper/js/dataTables.rowGroup.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('paper/js/dataTables.responsive.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js" crossorigin="anonymous"></script>



    <!-- Toast -->
    <!-- <script type="text/javascript" src="{{ asset('paper/js/jquery.toast.min.js') }}"></script> -->
    <script type="text/javascript" src="{{ asset('paper/js/toastr.min.js') }}"></script>

    <!-- jQuery UI 
    <script type="text/javascript" src="{{ asset('paper/js/core/jquery-ui.1.12.1.min.js') }}"></script>-->

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



    <!-- Chart Js -->
    <script src="{{ asset('paper/js/plugins/chartjs/Chart.js') }}"></script>

    <!-- Easy Pie Chart -->
    <script src="{{ asset('paper/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>

    <!-- InputFile -->
    <script src="{{ asset('paper/js/plugins/bootstrap-filestyle.min.js') }}" defer></script>


    <script src="{{ asset('paper/js/moment-with-locales.js') }}"></script>
    <script src="{{ asset('paper/js/moment-timezone.js') }}"></script>


    

    @auth()
    <!-- Notificaiones --> 
    <script src="{{ asset('paper/js/pushNotificaciones.js') }}"></script>
    @endauth

    @stack('scripts')

</body>

</html>