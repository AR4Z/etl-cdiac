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


                    <div id="container" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto"></div>




                </div>
                <div class="panel-body">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')


    <script>

        Highcharts.chart('container', {
            chart: {
                type: 'scatter',
                zoomType: 'xy'
            },
            title: {
                text: 'Gráfica de Dispersión'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                title: {
                    enabled: true,
                    text: 'valor'
                },
                startOnTick: true,
                endOnTick: true,
                showLastLabel: true
            },
            yAxis: {
                title: {
                    text: 'valor'
                }
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                verticalAlign: 'top',
                x: 100,
                y: 70,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF',
                borderWidth: 1
            },
            plotOptions: {
                scatter: {
                    marker: {
                        radius: 5,
                        states: {
                            hover: {
                                enabled: true,
                                lineColor: 'rgb(100,100,100)'
                            }
                        }
                    },
                    states: {
                        hover: {
                            marker: {
                                enabled: false
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<b>{series.name}</b><br>',
                        pointFormat: '{point.x} , {point.y} '
                    }
                }
            },
            series: [{
                name: '<?php echo ($_POST[$datas['criterio']])?>',
                color: 'rgba(223, 83, 83, .5)',
                data: (function() {
                    var data = [];
                    <?php
                    for($i = 0 ;$i<=count($outlier)-1;$i++){
                    ?>
                    data.push([<?php echo array_column($outlier,$var)[$i];?>,<?php echo array_column($outlier,'año')[$i];?>]);
                    <?php } ?>
                        return data;
                })(),



            }]
        });

    </script>

@endsection