@extends('template.main')

@section('title', 'Inicio')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    {!! Form::open(['route'=> 'users.create_user','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                        <label for="lastName" class="col-md-4 control-label">Apellidos</label>

                        <div class="col-md-6">
                            <input id="lastName" type="text" class="form-control" name="lastName" value="{{ old('lastName') }}" required autofocus>

                            @if ($errors->has('lastName'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Correo Electronico</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="form-group {{ $errors->has('institution') ? ' has-error' : '' }}">

                            {{ Form::label('institution', 'Institución a la que pertenece: ', ['class' => 'col-lg-3 control-label']) }}
                            <div class="col-lg-8">
                                {!!  Form::select('institution',
                                     [
                                        'GAIA'=>'GAIA',
                                        'GTA Ingeniería Hidráulica y Ambiental'=>'GTA Ingeniería Hidráulica y Ambiental ',
                                        'IDEA'=>'IDEA',
                                        'Corpocaldas'=>'Corpocaldas',
                                        'Universidad Nacional de Colombia'=>'Universidad Nacional de Colombia',
                                        'Alcaldía de Manizales'=>'Alcaldía de Manizales ',
                                        'IDEAM'=>'IDEAM',
                                        'ASI'=>'ASI',
                                        'Ciifen'=>'Ciifen',
                                        'SIAR'=>'SIAR',
                                        'SGC'=>'SGC '
                                     ],null,['class' => 'form-control', 'id'=> 'institution', 'required']) !!}
                                @if ($errors->has('institution'))
                                    <span class="help-block"><strong>{{ $errors->first('institution') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('rol') ? ' has-error' : '' }}">

                        {{ Form::label('rol', 'Rol: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('rol',
                                 [
                                    'Rol1'=>'Rol-1',
                                    'Rol2'=>'Rol-2 ',
                                    'Rol3'=>'Rol-3',
                                    'Rol4'=>'Rol-4',
                                    'Todos'=>'Todos'
                                 ],null,['class' => 'form-control', 'id'=> 'rol', 'required']) !!}
                            @if ($errors->has('rol'))
                                <span class="help-block"><strong>{{ $errors->first('rol') }}</strong></span>
                            @endif
                        </div>
                    </div>
                </div>


                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascript')
@endsection
