@extends('template.main')

@section('title', ' Auditory')

@section('content')

    <div class="row">
        <div class="page-header">
            <h1>Resultado de busqueda de datos <small></small></h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Auditoría de la estación &nbsp {{$station}} &nbsp ( De &nbsp {{ $search['start'] }} &nbsp Hasta &nbsp {{ $search['end'] }} )
                    </h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route'=> 'auditory.graphics','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}

                    <table id="data-table" class="display table" cellspacing="0" width="100%">
                        <thead>

                        <th>Variable</th>

                        <th>Criterio Calidad de los Datos</th>


                        <th>Cantidad de datos analizados</th>

                        <th>Media</th>

                        <th>Desviación estandar</th>

                        <th>Limite inferior</th>

                        <th>Limite superior</th>
                        <th>Cantidad de fallos detectados</th>


                        <th>Vulnerabilidad</th>

                        </thead>                        <tbody>
                            @foreach($data_risk as $datas)
                                <tr>
                                    <td>{{$datas['variable']}}</td>
                                    <td>{{$datas['criterio']}}</td>
                                    <td>{{$datas['total_data']}}</td>
                                    <td>{{$datas['average']}}</td>
                                    <td>{{$datas['deviation']}}</td>
                                    <td>{{$datas['start_limit']}}</td>
                                    <td>{{$datas['end_limit']}}</td>
                                    <td>{{$datas['riskQuantity']}}</td>
                                    <td>{{$datas['vulnerabillity']}}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {!! Form::close() !!}
                    <div class=" col-lg-5 btn-group  pull-right">
                        <input type="button" value="Graficar" onclick="graphic()" name="graphic" id="graphic" class="btn btn-info">
                    </div>

                    <div id="chart_div" style="width: 900px; height: 500px;"></div>
                </div>



            </div>
        </div>
    </div>

@endsection

@section('javascript')

    <script>

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = [];
            <?php
            for($i = 0 ;$i<=count($outlier)-1;$i++){
            ?>
            data.push([<?php echo array_column($outlier,$var)[$i];?>,<?php echo array_column($outlier,$var)[$i];?>]);
            <?php } ?>
                return data;

            var options = {
                title: 'Age vs. Weight comparison',
                hAxis: {title: 'Age'},
                vAxis: {title: 'Weight'},
                legend: 'none'
            };

            var chart = new google.visualization.ScatterChart(document.getElementById('chart_div'));

            chart.draw(data, options);
        }








        function graphic() {
            $("#container").show();
        }



    </script>



@endsection
