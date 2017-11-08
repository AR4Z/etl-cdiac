@extends('template.main')

@section('title', ' Stations in Server Acquisition')

@section('content')

    <div class="row">
        <div class="page-header">
            <h1>Estaciones en el servidor de adquisición <small></small></h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Estaciones en cada base de datos</h3>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="display table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <td>Conección</td>
                                <td>Host</td>
                                <td>Puerto</td>
                                <td>Base de datos</td>
                                <td>usuario</td>
                                <td>tabla (estacion)</td>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($stations as $station)
                            <tr>@foreach($station as $variable)<td>{{ $variable }}</td>@endforeach</tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

@endsection