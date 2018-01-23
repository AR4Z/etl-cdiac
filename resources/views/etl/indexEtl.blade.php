@extends('template.main')

@section('title', 'Etl Plane')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <h1>Etl - Central de Acopio</h1>
        <br><br>

        <div class="row">
            {!! Form::open(['route'=> 'execute-etl.redirectionEtlFilter','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label', 'enctype'=>'multipart/form-data']) !!}

            <div class="form-group {{ $errors->has('method') ? ' has-error' : '' }}">
                {{ Form::label('method', 'Metodo: ', ['class' => 'col-md-3 control-label']) }}
                <div class="col-md-9">
                    {!! Form::select('method', ['Filter' => 'Filtrar', 'Original'=>'Original','All'=> 'Original + Filtrar'] , null ,['class' => 'form-control', 'id'=> 'method', 'required']) !!}
                    @if ($errors->has('method'))
                        <span class="help-block">
                                <strong>{{ $errors->first('method') }}</strong>
                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('net_name') ? ' has-error' : '' }}">
                {{ Form::label('net_name', 'Red: ', ['class' => 'col-md-3 control-label']) }}
                <div class="col-md-9">
                    {!! Form::select('net_name', $differentNetName , null ,['class' => 'form-control', 'id'=> 'net_name', 'required']) !!}
                    @if ($errors->has('net_name'))
                        <span class="help-block">
                                <strong>{{ $errors->first('net_name') }}</strong>
                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('station_id') ? ' has-error' : '' }}">
                {{ Form::label('station_id', 'Estación: ', ['class' => 'col-md-3 control-label']) }}
                <div class="col-md-9">
                    {!!  Form::select('station_id', [],null,['class' => 'form-control', 'id'=> 'station_id', 'required']) !!}
                    @if ($errors->has('station_id'))
                        <span class="help-block">
                                <strong>{{ $errors->first('station_id') }}</strong>
                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('date_range') ? ' has-error' : '' }}">
                {{ Form::label('date_range', 'Rango de Fechas: ', ['class' => 'col-lg-3 control-label','required']) }}
                <div class="col-lg-9" id="sandbox-container">
                    <div class="input-daterange input-group" id="datepicker">
                        <span class="input-group-addon">De</span>
                        <input required  type="text" class="input-sm form-control" name="start"/>
                        <span   class="input-group-addon">Hasta</span>
                        <input required type="text" class="input-sm form-control" name="end" />
                        @if ($errors->has('date_range'))
                            <span class="help-block">
                                <strong>{{ $errors->first('date_range') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="" id="optional_fields" style="display: none">
                <div class="form-group {{ $errors->has('sequence') ? ' has-error' : '' }}">
                    {{ Form::label('sequence', 'Secuencia: ', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-9">
                        <input type="checkbox" data-toggle="toggle" data-size="mini" class="disabled"
                               data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        @if ($errors->has('sequence'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('sequence') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('trust_process') ? ' has-error' : '' }}">
                    {{ Form::label('trust_process', 'Calidad de datos: ', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-9">
                        <input type="checkbox" data-toggle="toggle" data-size="mini" class="disabled"
                               data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        @if ($errors->has('trust_process'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('trust_process') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('serialization') ? ' has-error' : '' }}">
                    {{ Form::label('serialization', 'Serialización: ', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-9">
                        <input type="checkbox" data-toggle="toggle" data-size="mini" class="disabled"
                               data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        @if ($errors->has('serialization'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('serialization') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('filter_detection') ? ' has-error' : '' }}">
                    {{ Form::label('filter_detection', 'Filtro de Detección: ', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-9">
                        <input type="checkbox" data-toggle="toggle" data-size="mini" class="disabled"
                               data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        @if ($errors->has('filter_detection'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('filter_detection') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('filter_correction') ? ' has-error' : '' }}">
                    {{ Form::label('filter_correction', 'Filtro de Corrección: ', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-9">
                        <input type="checkbox" data-toggle="toggle" data-size="mini" class="disabled"
                               data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        @if ($errors->has('filter_correction'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('filter_correction') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('load') ? ' has-error' : '' }}">
                    {{ Form::label('load', 'Cargar: ', ['class' => 'col-md-3 control-label']) }}
                    <div class="col-md-9">
                        <input type="checkbox" data-toggle="toggle" data-size="mini" class="disabled"
                               data-on="Si" data-off="No" data-onstyle="success" data-offstyle="danger">
                        @if ($errors->has('load'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('load') }}</strong>
                                </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="">
                <button type="submit" class="btn btn-raised btn-success btn-inline pull-right">Enviar</button>
            </div>

            {!! Form::close() !!}
        </div>

    </div>

@endsection

@section('javascript')
    <script>
        $('#net_name').change(function () {
            $('#station_id').empty();
            var id = $(this).val();
            if ( id === ''){
                $('#station_id').empty();
            }else{
                $.post('/etl-cdiac/execute-etl/getStationsForNet',{ id: id },function (values) {
                    $('#station_id').populateSelect(values);
                },'json');
            }
        })
    </script>

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
