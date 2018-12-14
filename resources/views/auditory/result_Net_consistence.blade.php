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
                        Auditoría de la red &nbsp {{$net}} &nbsp ( De &nbsp {{ $search['start'] }} &nbsp Hasta &nbsp {{ $search['end'] }} )
                    </h3>
                </div>
                <div class="panel-body">
                    {!! Form::open(['route'=> 'auditory.graphics','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}

                    <table id="data-table" class="display table" cellspacing="0" width="100%">
                        <thead>
                        <th>Estación</th>

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
                                    <td>{{$datas['station']}}</td>
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
                    <div class=" col-lg-5 btn-group  pull-right">
                        <button type="submit" class="btn btn-success">Gráficos y Análisis</button>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

@endsection