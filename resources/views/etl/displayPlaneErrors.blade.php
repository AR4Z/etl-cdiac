@extends('template.main')

@section('title', 'Display Errors Etl Plane')

@section('content')

    <div class="col-lg-8 col-lg-offset-2">

        <div class="form-group {{ $errors->has('errorPlane') ? ' has-error' : '' }}">
              @if ($errors->has('errorPlane'))
                    <span class="help-block">
                        <strong>{{ $errors->first('errorPlane') }}</strong>
                    </span>
                @endif

        </div>

        <div>
            <h1>Errores Encontrados</h1>
            <br>
            @if(!empty(($validate['notExist']) and !empty($validate['notFind']) or (empty($validate['notExist']) and !empty($validate['notFind']))))
                <div class="col-md-10 col-md-offset-1">
                    @if(!empty($validate['notExist']))
                    <div class="card">
                        <h4>La(s) sigiente(s) variable(s) deveria(n) estar en el archivo y no esta(n) : </h4>
                        <ul class="list-group list-group-flush">
                            @foreach($validate['notExist'] as $key => $value)
                                <li class="list-group-item">{{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="card">
                        <h4>La(s) sigiente(s) variable(s) no se reconoce(n) como variable(s) de la estación : </h4>
                        <ul class="list-group list-group-flush">
                            @foreach($validate['notFind'] as $key => $value)
                                <li class="list-group-item">{{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <h3 class="label-danger text-center">Revise los Requerimientos para cargar el archivo y vuelva a cargarlo</h3>
                        <br>
                        <h4 class="label-danger text-center">El Archivo deber ser CSV- delimitado por comas con codificacion UTF-8</h4>
                        <br>
                        <a href="{{ route('plane-etl.index') }}" class="btn btn-success btn-block btn-group-justified">Volver</a>
                    </div>
                </div>
            @endif
        </div>
        <div>
            @if(!empty($validate['notExist']) and empty($validate['notFind']))
                <div class="">
                    <div class="card">
                        <h4>La(s) sigiente(s) variable(s) deveria(n) estar en el archivo y no esta(n) : </h4>
                        <ul class="list-group list-group-flush">
                            @foreach($validate['notExist'] as $key => $value)
                                <li class="list-group-item">{{ $value }}</li>
                            @endforeach
                        </ul>
                        <div>
                            <h5>+ Si preciona en 'continuar' la(s) variable(s) faltante(s) será(n) tomada(s) como null.</h5>
                            <h5>+ Puede arreglar el archivo y presionar en 'volver a cargar'.</h5>
                        </div>
                    </div>

                    <div class="card">
                        <br>
                        <div>
                            {!! Form::open(['route'=> 'plane-etl.loadFileErrors','method'=> 'POST']) !!}
                                {{ Form::hidden('options', $options) }}
                                <div class="">
                                    <a href="{{ route('plane-etl.index') }}" class="btn btn-danger pull-left">Volver a Cargar</a>
                                    <button type="submit" class="btn btn-raised btn-success btn-inline pull-right">Continuar</button>
                                </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            @endif
                <br> <br> <br> <br>
        </div>


    </div>

@endsection


@section('javascript')
    <script>

    </script>
@endsection