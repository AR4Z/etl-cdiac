@extends('template.main')

@section('title', 'Etl Plane')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">
        <h1>Etl - Archivos Planos</h1>
        <br><br>
        <div class="col-lg-10 col-lg-offset-1">
            {!! Form::open(['route'=> 'plane-etl.loadFile','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label', 'enctype'=>'multipart/form-data']) !!}
                <div class="form-group">
                    {{ Form::label('net_name', 'Red: ', ['class' => 'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {!! Form::select('net_name', $differentNetName , null ,['class' => 'form-control', 'id'=> 'net_name', 'required']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {{ Form::label('station_id', 'Estación: ', ['class' => 'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {!!  Form::select('station_id', [],null,['class' => 'form-control', 'id'=> 'station_id', 'required']) !!}
                    </div>
                </div>

                <div class="form-group">
                    {{ Form::label('file', 'Archivo: ', ['class' => 'col-md-2 control-label']) }}
                    <div class="col-md-10">
                        {{ Form::file('file',['class'=>'filestyle', 'data-iconName'=> '','data-placeholder'=>'Seleccione Un Archivo CSV-delimitado por comas   -->','required']) }}
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