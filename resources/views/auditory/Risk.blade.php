@extends('template.main')

@section('title', 'Inicio')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Ingrese la información del riesgo</h3></div>
            <div class="panel-body">
                {!! Form::open(['route'=> 'auditory.save-risk','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}

                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                        {{ Form::label('name', 'Nombre del riesgo: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                                <input type="text" class="input-sm form-control" name="name" />
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }}">
                        {{ Form::label('description', 'Descripción del riesgo: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            <input type="text" class="input-sm form-control" name="description" />
                        </div>
                    </div>
                </div>



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
                    <div class="form-group {{ $errors->has('variable_id') ? ' has-error' : '' }}">
                        {{ Form::label('variable_id', 'Variable: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('variable_id', $variable,null,['class' => 'form-control', 'id'=> 'variable_id', 'required']) !!}
                            @if ($errors->has('variable_id'))
                                <span class="help-block"><strong>{{ $errors->first('variable_id') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>




                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('initial_value') ? ' has-error' : '' }}">
                        {{ Form::label('range', 'Rangos de valores del riesgo: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            <div class="input-group" >
                                <span class="input-group-addon">Valor Minimo</span>
                                <input type="text" class="input-sm form-control" name="start" />
                                <span class="input-group-addon">Valor Maximo</span>
                                <input type="text" class="input-sm form-control" name="end" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('negativeRule') ? ' has-error' : '' }}">

                        {{ Form::label('negativeRule', 'Regla de datos negativos: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('negativeRule',
                                 [
                                    '1'=>'Si',
                                    '2'=>'No ',
                                 ],null,['class' => 'form-control', 'id'=> 'negativeRule', 'required']) !!}
                            @if ($errors->has('negativeRule'))
                                <span class="help-block"><strong>{{ $errors->first('negativeRule') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('nullRule') ? ' has-error' : '' }}">

                        {{ Form::label('nullRule', 'Regla de datos nulos por estación: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('nullRule',
                                 [
                                    '1'=>'Si',
                                    '2'=>'No ',
                                 ],null,['class' => 'form-control', 'id'=> 'nullRule', 'required']) !!}
                            @if ($errors->has('nullRule'))
                                <span class="help-block"><strong>{{ $errors->first('nullRule') }}</strong></span>
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