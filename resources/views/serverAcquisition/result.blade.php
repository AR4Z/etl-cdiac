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
                        Estacion {{ $station->name }} ( De &nbsp {{ $search['start'] }} &nbsp Hasta &nbsp {{ $search['end'] }} )
                    </h3>
                </div>
                <div class="panel-body">
                    <table id="data-table" class="display table" cellspacing="0" width="100%">
                        <thead><tr>@foreach($keys as $key)<th>{{$key}}</th>@endforeach</tr></thead>
                        <tbody>
                            @foreach($externalData as $dataExternal)
                                <tr>@foreach($keys as $key)<td>{{ $dataExternal->$key }}</td>@endforeach</tr>
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