@extends('template.main')

@section('title', 'Etl Plane')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <h1>Etl - Archivos Planos</h1>
        <br><br>

        <div class="col-lg-10 col-lg-offset-1">
            {!! Form::open(['route'=> 'plane-etl.loadFile','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label', 'enctype'=>'multipart/form-data']) !!}

            <div class="form-group {{ $errors->has('method') ? ' has-error' : '' }}">
                {{ Form::label('method', 'Metodo: ', ['class' => 'col-md-2 control-label']) }}
                <div class="col-md-10">
                    {!! Form::select('method', ['Filter' => 'Filtrar', 'Original'=>'Original','All'=> 'Original + Filtrar'] , null ,['class' => 'form-control', 'id'=> 'method', 'required']) !!}
                    @if ($errors->has('method'))
                        <span class="help-block">
                                <strong>{{ $errors->first('method') }}</strong>
                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('sequence') ? ' has-error' : '' }}">
                {{ Form::label('sequence', 'Secuencia: ', ['class' => 'col-md-2 control-label']) }}
                <div class="col-md-10">
                    {!! Form::select('sequence', ['true'=>'Si','false' => 'No'] , null ,['class' => 'form-control', 'id'=> 'sequence', 'required']) !!}
                    @if ($errors->has('sequence'))
                        <span class="help-block">
                                <strong>{{ $errors->first('sequence') }}</strong>
                            </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('net_name') ? ' has-error' : '' }}">
                    {{ Form::label('net_name', 'Red: ', ['class' => 'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {!! Form::select('net_name', $differentNetName , null ,['class' => 'form-control', 'id'=> 'net_name', 'required']) !!}
                        @if ($errors->has('net_name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('net_name') }}</strong>
                            </span>
                        @endif
                    </div>
            </div>
                <div class="form-group {{ $errors->has('station_id') ? ' has-error' : '' }}">
                    {{ Form::label('station_id', 'Estación: ', ['class' => 'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {!!  Form::select('station_id', [],null,['class' => 'form-control', 'id'=> 'station_id', 'required']) !!}
                        @if ($errors->has('station_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('station_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group {{ $errors->has('file') ? ' has-error' : '' }}">
                    {{ Form::label('file', 'Archivo: ', ['class' => 'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {{ Form::file('file',['class'=>'filestyle', 'data-iconName'=> '','data-placeholder'=>'Seleccione Un Archivo CSV-delimitado por comas   -->','required']) }}
                        @if ($errors->has('file'))
                            <span class="help-block">
                                <strong>{{ $errors->first('file') }}</strong>
                            </span>
                        @endif

                    </div>

                </div>

                <div class="">
                    <button type="submit" class="btn btn-raised btn-success btn-inline pull-right">Enviar</button>
                </div>

            {!! Form::close() !!}
        </div>



        </div>

    </div>

@endsection

@section('javascript')
    <script>
        $('#net_name').change(function () {
            $('#station_id').empty();
            var net_name = $(this).val();
            if ( net_name === ''){
                $('#station_id').empty();
            }else{
                $.post('/etl-cdiac/plane-etl/getStationsForNet',{ net_name: net_name },function (values) {
                    $('#station_id').populateSelect(values);
                },'json');
            }
        })
    </script>

@endsection