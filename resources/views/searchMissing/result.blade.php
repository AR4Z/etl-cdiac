@extends('template.main')

@section('title', ' Server Acquisition')

@section('content')

    <div class="row">
        <div class="page-header">
            <h1>Informe de datos faltantes <small></small></h1>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Datos faltantes para la {{ $fact_table }}
                    </h3>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="display table" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre Estación</th>
                                <th>Fecha</th>
                                <th>Cantidad de Datos Existentes</th>
                                <th>Porcentaje Datos Recuperado</th>
                                <th>Porcentaje Datos Faltante</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($missingArray as $missing)
                            <tr>
                                <td>{{ $missing->name }}</td>
                                <td>{{ $missing->date }}</td>
                                <td>{{ $missing->count }}</td>
                                <td>{{ $missing->recoveredPercentage }}</td>
                                <td>{{ $missing->missingPercentage }}</td>
                            </tr>
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