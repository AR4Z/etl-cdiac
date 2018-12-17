@extends('template.main')

@section('title', ' Server Acquisition')

@section('content')

    <div class="row">
        <div class="page-header">
            <h1>Resultado de busqueda de datos <small></small></h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">


                    <p>
                        <canvas id="densityChart" width="600" height="400"></canvas> </p>




                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('text/javascript')

    <script>
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Productos', 'mes'],
                    @foreach ($pastel as $pastels)
                ['{{ $pastels->ubicacion}}', {{ $pastels->total}}],
                @endforeach
            ]);
            var options = {
                title: 'Representación grafica de clientes por ubicacion'
            };
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    </script>




@endsection