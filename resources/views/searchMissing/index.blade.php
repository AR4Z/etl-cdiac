@extends('template.main')

@section('title', 'Etl Plane')

@section('content')

    <div class="row">
        <div class="page-header">
            <h1>Consulta De Datos Faltantes </h1>
        </div>
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h3 class="panel-title">Configure la Consulta</h3></div>
                <div class="panel-body">
                    {!! Form::open(['route'=> 'search-missing.search-data','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="form-group {{ $errors->has('fact_table') ? ' has-error' : '' }}">

                                {{ Form::label('fact_table', 'Tabla de Hechos: ', ['class' => 'col-lg-3 control-label']) }}
                                <div class="col-lg-8">
                                    {!!  Form::select('fact_table',
                                         [
                                            'groundwater_fact'=>'Aguas freáticas',
                                            'original_weather_fact'=>'Climatológicos originales',
                                            'weather_fact'=>'Climatológicos filtrados',
                                         ],null,['class' => 'form-control', 'id'=> 'fact_table', 'required']) !!}
                                    @if ($errors->has('fact_table'))
                                        <span class="help-block"><strong>{{ $errors->first('fact_table') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="form-group {{ $errors->has('station_id') ? ' has-error' : '' }}">
                                {{ Form::label('station_id', 'Estación: ', ['class' => 'col-md-3 control-label']) }}
                                <div class="col-md-8">
                                    {!!  Form::select('station_id', [],null,['class' => 'form-control', 'id'=> 'station_id', 'required']) !!}
                                    @if ($errors->has('station_id'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('station_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            {{ Form::hidden('type_station', null, array('id' => 'type_station')) }}
                        </div>

                        <div class=" col-lg-5 btn-group  pull-right">
                            <button type="button" class="btn btn-default">Cancelar</button>
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    <script>
        $( document ).ready(function() {
            $('#fact_table').change(function () {
                $('#station_id').empty();
                var fact_table = $(this).val();
                if (fact_table === '') {
                    $('#station_id').empty();
                } else {
                    changeTypeStation(fact_table);
                    $.post('/search-missing/stationsForFactTable', {type_station: $('#type_station').val()}, function (values) {
                        //console.log(values);
                        $('#station_id').populateSelect(values);
                    }, 'json');
                }
            });
        });

        function changeTypeStation(fact_table)
        {
            var typeStation = $('#type_station');

            if (fact_table == "groundwater_fact"){
               typeStation.val("groundwater");
            }else{
                if(fact_table == "original_air_fact" || fact_table == "air_fact"){
                    typeStation.val("air");
                }else{
                    typeStation.val("weather");
                }
            }
        }
    </script>
@endsection