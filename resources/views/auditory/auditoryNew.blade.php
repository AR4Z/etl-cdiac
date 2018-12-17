@extends('template.main')

@section('title', 'Inicio')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Configure consulta</h3></div>
            <div class="panel-body">
                {!! Form::open(['route'=> 'auditory.make-auditory','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}
                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('station_id') ? ' has-error' : '' }}">
                        {{ Form::label('station_id', 'Estación: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('station_id', $stations,null,['class' => 'form-control', 'id'=> 'station_id', 'required']) !!}
                            @if ($errors->has('station_id'))
                                <span class="help-block"><strong>{{ $errors->first('station_id') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('dataQuality') ? ' has-error' : '' }}">

                        {{ Form::label('data_quality', 'Criterio de calidad de los datos: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('dataQuality',
                                 [
                                    '1'=>'Exactitud',
                                    '2'=>'Integridad ',
                                    '3'=>'Completitud',
                                    '4'=>'Todos'
                                 ],null,['class' => 'form-control', 'id'=> 'dataQuality', 'required']) !!}
                            @if ($errors->has('dataQuality'))
                                <span class="help-block"><strong>{{ $errors->first('dataQuality') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>


                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('initial_date') ? ' has-error' : '' }}">
                        {{ Form::label('date_range', 'Rango de Fechas: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8" id="sandbox-container">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">De</span>
                                <input type="text" class="input-sm form-control" name="start" />
                                <span class="input-group-addon">Hasta</span>
                                <input type="text" class="input-sm form-control" name="end" />
                            </div>
                        </div>
                    </div>
                </div>




                <div class=" col-lg-5 btn-group  pull-right">
                    <button type="button" class="btn btn-default">Cancelar</button>
                    <button type="submit" class="btn btn-success">Aceptar</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script>
        $('#sandbox-container .input-daterange').datepicker({
            startView: 1,
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true,
            todayHighlight: true,
            toggleActive: true,
            startDate: "2012-01-01",
            endDate: new Date(),
            calendarWeeks: true,
            todayBtn: "linked"
        });
    </script>
@endsection