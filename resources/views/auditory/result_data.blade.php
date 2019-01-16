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
                    <h3 class="panel-title">
                        Criterio de calidad de los datos {{ $search['dataQuality'] }} &nbsp de la Estación &nbsp {{$station}} ( De &nbsp {{ $search['start'] }} &nbsp Hasta &nbsp {{ $search['end'] }} )
                    </h3>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="display table" cellspacing="0" width="100%">
                        <thead>

                        <th>Variable</th>

                        <th>Cantidad de datos analizados</th>


                        <th>Cantidad de datos detectados</th>


                        <th>Vulnerabilidad</th>

                        </thead>

                        <tbody>
                        <tr>
                        <td>{{$variable}}</td>
                        <td>{{$data[1]}}</td>
                        <td>{{$data[2]}}</td>
                        <td>{{$data[0]}}%</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

@endsection