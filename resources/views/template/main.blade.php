<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if IE 9]> <html class="ie9 oldie"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html>
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <!-- 
  =============================================================================
  === PLANTILLA DESARROLLADA POR LA OFICINA DE MEDIOS DIGITALES - UNIMEDIOS ===
  =============================================================================
-->
    <!-- base href="http://subdominio.unal.edu.co/" -->
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
    <meta name="revisit-after" content="1 hour">
    <meta name="distribution" content="all">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.5, maximum-scale=2.5, user-scalable=yes">
    <meta name="expires" content="1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="all">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-theme.min.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/unal.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/base.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/tablet.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/phone.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/small.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/printer.css') }}" media="print">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/metisMenu.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset('libraries/bootstrap-datepicker/css/bootstrap-datepicker3.standalone.min.css') }}" media="all">

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" media="all">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">


    <title>@yield('title', 'Inicio - Universidad Nacional de Colombia')</title>
</head>

<body>
    <div id="services">
        <div class="indicator hidden-xs"></div>
        <ul class="dropdown-menu">
            <li>
                <a href="http://correo.unal.edu.co" target="_blank"><img src="{{ asset('images/icnServEmail.png') }}" width="32" height="32" alt="Correo Electrónico">Correo Electrónico</a>
            </li>
            <li>
                <a href="http://www.sia.unal.edu.co" target="_blank"><img src="{{ asset('images/icnServSia.png') }}" width="32" height="32" alt="Sistema de Información Académica">Sistema de Información Académica</a>
            </li>
            <li>
                <a href="http://www.sinab.unal.edu.co" target="_blank"><img src="{{ asset('images/icnServLibrary.png') }}" width="32" height="32" alt="Biblioteca">Biblioteca</a>
            </li>
            <li>
                <a href="http://168.176.5.43:8082/Convocatorias/indice.iface" target="_blank"><img src="{{ asset('images/icnServCall.png') }}" width="32" height="32" alt="Convocatorias">Convocatorias</a>
            </li>
            <li>
                <a href="http://identidad.unal.edu.co"><img src="{{ asset('images/icnServIdentidad.png') }}" width="32" height="32" alt="Identidad U.N.">Identidad U.N.</a>
            </li>
        </ul>
    </div>

    <div id="app">

        @section('header')
            @include('template.header')
        @show

        @section('menu')
            @include('template.menu')
        @show


        <main class="detalle">
            <div class="row">
                <br>
                @yield('content')
            </div>

        </main>

        @section('footer')
            @include('template.footer')
        @show

    </div>
    <script src="{{ asset(elixir('js/app.js'))  }}"></script>
    <script src="{{ asset('js/unal.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sb-admin-2.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/metisMenu.js') }}" type="text/javascript"></script>
    {{--[if lt IE 9]--}}
    <script src="{{ asset('js/html5shiv.js') }}" type="text/javascript"></script>
    {{--[endif]--}}
    {{--<!--[if lt IE 9]>--}}
    <script src="{{ asset('js/respond.js') }}" type="text/javascript"></script>
    {{--<![endif]-->--}}

    <script type="text/javascript" src="{{ asset('js/bootstrap-filestyle-1.2.3/src/bootstrap-filestyle.min.js')}}"> </script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.16/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>

    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="graficas/googlechart.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/series-label.js"></script>
    <script type="text/javascript" src="https://code.highcharts.com/modules/exporting.js"></script>

    <script src="{{asset('libraries/bootstrap-datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{asset('libraries/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

    <script>

        this.axios = axios.create({ baseURL: 'http://cdiac.manizales.unal.edu.co/etl-cdiac/'});

        $(document).ready(function () {
            /* Se inicializan los select de la pagina con select2*/
            $('select').select2({allowClear: true, placeholder: {id: -1, text: "Seleccione un valor"}}).val('').change();

            /* Se crea la funcion para incluir las respuestas por api en los select*/
            $.fn.populateSelect = function (values) {
                var options = '';
                $.each(values, function (key, row) { options += '<option value="' + row.id + '">' + row.name + '</option>'; });
                $(this).html(options);
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#data-table').DataTable({
                scrollX: true,
                language: {
                    "Show": "ver",
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "NingÃºn dato disponible en esta tabla",
                    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Ãšltimo",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "pageLength": {
                            _: "Ver %d Registros",
                            '-1': "Todos los Registros"
                        }
                    }
                },
                dom: 'Bfrtip',
                lengthMenu:[[10,25,50,-1],[ '10', '25','50', 'Ver Todos' ]],
                buttons: [
                    { extend:    'pageLength'},
                    {
                        title:     'Data export',
                        extend:    'excelHtml5',
                        text:      '<i class="fa fa-file-excel-o"></i>',
                        titleAttr: 'Descargar Excel'
                    },
                    {
                        title:     'Data export',
                        extend:    'csvHtml5',
                        text:      '<i class="fa fa-file-text-o"></i>',
                        titleAttr: 'Descargar CSV'
                    },
                    {
                        title:     'Data export',
                        extend:    'pdfHtml5',
                        text:      '<i class="fa fa-file-pdf-o"></i>',
                        titleAttr: 'Descargar PDF'
                    }
                ]
            });
        } );
    </script>
    @yield('javascript')

</body>

</html>