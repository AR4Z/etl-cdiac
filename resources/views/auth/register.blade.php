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

                    <div class="form-group{{ $errors->has('identification_document') ? ' has-error' : '' }}">
                        <label for="identification_document" class="col-md-4 control-label">Documento de identificación</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="identification_document" value="{{ old('identification_document') }}" required autofocus>

                            @if ($errors->has('identification_document'))
                            <span class="help-block">
                                <strong>{{ $errors->first('identification_document') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

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

                    <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label for="lastname" class="col-md-4 control-label">Apellidos</label>

                        <div class="col-md-6">
                            <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>

                            @if ($errors->has('lastname'))
                            <span class="help-block">
                                <strong>{{ $errors->first('lastname') }}</strong>
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
                                {!! Form::select('institution',
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
                                {!! Form::select('rol', array_pluck($roles, 'name', 'id'), null, ['class' => 'form-control', 'id'=> 'rol', 'required']) !!}
                                @if ($errors->has('rol'))
                                <span class="help-block"><strong>{{ $errors->first('rol') }}</strong></span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-lg-offset-2">
                        <div class="form-group {{ $errors->has('application') ? ' has-error' : '' }}">
                            {{ Form::label('application', 'Aplicación a la que desea tener acceso: ', ['class' => 'col-lg-3 control-label']) }}
                            <div class="col-lg-8">
                                {!! Form::select('application', ['all' => 'Todas'] + array_pluck($applications, 'name', 'id'), null, ['class' => 'form-control', 'id'=> 'rol', 'required']) !!}
                                @if ($errors->has('application'))
                                <span class="help-block"><strong>{{ $errors->first('application') }}</strong></span>
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