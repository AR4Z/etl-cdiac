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
                        <th>Criterio Calidad de lo Datos</th>
                        <th>Tipo de Riesgo</th>
                        <th>Cantidad de datos analizados</th>
                        <th>Cantidad de fallos detectados</th>
                        <th>Vulnerabilidad</th>

                        </thead>
                        <tbody>
                        @foreach($data_risk as $datas)
                            <tr>
                                <td>{{$datas['variable']}}</td>
                                <td>{{$datas['criterio']}}</td>
                                <td>{{$datas['risk']}}</td>
                                <td>{{$datas['total_data']}}</td>
                                <td>{{$datas['riskQuantity']}}</td>
                                <td>{{$datas['vulnerabillity']}}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                            </div>
                        </div></div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')


    <script>

        Highcharts.chart('container', {
            title: {
                text: 'Auditory Results'
            },
            xAxis: {
                categories: ["<?php echo $datas['risk']?>"]
            },
            labels: {
                items: [{
                    html: 'Cantidad total de riesgos',
                    style: {
                        left: '50px',
                        top: '18px',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'
                    }
                }]
            },


            series: [

                {
                type: 'column',
                name: '<?php echo $datas['criterio'];?>',
                data: (function() {
                    var data = [];
                    <?php
                    for($i = 0 ;$i<count($data_risk);$i++){
                    ?>
                    data.push([<?php echo array_column($data_risk,'riskQuantity')[$i];?>]);
                    <?php } ?>
                        return data;
                })(),
            },   ]
        });


    </script>

@endsection