@extends('template.main')

@section('title', 'Inicio')

@section('content')

    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Auditoría</h3></div>
            <div class="panel-body">
                {!! Form::open(['route'=> 'auditory.make-auditory','method'=> 'POST', 'class'=> 'form-horizontal form-validate floating-label']) !!}


                <div class="text-justify">

                        <p>Este es el módulo de auditoria de la bodega de datos ambientales 1.0, con esta herramienta podrás analizar la calidad de los datos que se encuentran almacenados en la bodega. <br>
                            Los resultados y análisis de la auditoría se realizan basados en tres criterios de calidad de los datos y cada uno de estos tienen una cantidad de riesgos asociados, como se observa a continuación:<br>
                            <br><h4>Exactitud</h4><br>

                            Si los datos no son precisos, estos no pueden ser utilizados (PowerData, 2014; Valverde & Bianchi, 2009). Es decir, los datos capturados y almacenados son semejantes a los presentados en el mundo real. Para este criterio se calculan cinco riegos.<br>
                            <br>1.	Datos negativos en variables cuyos valores sean positivos.<br>
                            2.	Datos vacíos (null) con valor cero (0).<br>
                            3.	Datos en variables que la estación no calcula.<br>
                            4.	Datos con valores fuera de los rangos de las variables.<br>
                            5.	La diferencia entre los valores de los datos consecutivos no se cumple.<br>

                           <br> <h4>Integridad</h4><br>

                            Toda la información relevante de un registro está presente de forma que se pueda utilizar (PowerData, 2014; Valverde & Bianchi, 2009). Es decir, los datos almacenados no son alterados y mantienen sus propiedades tal y como se captaron en el mundo real. Para este criterio se calculan dos riegos.<br>
                            <br>6.	Los datos solo son recibidos de los sensores.<br>
                            7.	La cantidad de datos de la central de adquisición es menor a la cantidad de datos de la bodega.<br>
                            <br><h4>Completitud</h4><br>

                            Tener la mayor cantidad de datos posibles es relevante, ya que para un proceso del negocio, éstos se vuelven críticos (PowerData, 2014; Valverde & Bianchi, 2009). Es decir, garantizar que se capturen y almacenen la mayor cantidad de datos del mundo real, repercuten en ventajas para las organizaciones. Para este criterio de definieron tres riesgos.<br>
                            <br>8.	La cantidad que se espera de una estación en un tiempo determinado frente a los que en realidad se obtienen.<br>
                            9.	Cantidad de datos Nulos.<br>
                            10.	La cantidad de datos de la central de adquisición es mayor a la cantidad de datos de la bodega.<br><br>

                            <br><h4>Consistencia</h4><br>

                             Al hacer el cruce de información con los registros, se debe evitar la  información contradictoria.
                            <br>11.	La tipología de los datos es numérica.<br>
                            12.	La cantidad de datos atípicos debe ser lo menor posible.<br><br>

                            A continuación, puede empezar a realizar la auditoría de acuerdo al tipo de análisis que desee efectuar: <br>
                        </p>
                    <br>
                    <br>


                </div>

                <div class="col-lg-8 col-lg-offset-2">
                    <div class="form-group {{ $errors->has('auditoryType') ? ' has-error' : '' }}">

                        {{ Form::label('auditoryType', 'Seleccione el tipo de auditoría: ', ['class' => 'col-lg-3 control-label']) }}
                        <div class="col-lg-8">
                            {!!  Form::select('auditoryType',

                                 [  '1'=>'Auditoría de una variable en una estación',
                                    '2'=>'Auditoría de una variable en todas las estaciones',
                                    '3'=>'Auditoría de todas las variables de una estación',
                                    '4'=>'Auditoría de todas las variables en todas las estaciones',
                                    '5'=>'Auditoría de una  variable en todas las estaciones de una red',
                                    '6'=>'Auditoría de todas las variable en todas las estaciones de una red'

                                 ],null,['class' => 'form-control', 'id'=> 'auditoryType', 'required']) !!}
                            @if ($errors->has('auditoryType'))
                                <span class="help-block"><strong>{{ $errors->first('auditoryType') }}</strong></span>
                            @endif
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
@endsection