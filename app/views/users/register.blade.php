<head>
<link rel="icon" href="/public/favicon.ico">
<link rel="icon" href="/favicon.ico">
<link rel="icon" href="/public/favicon.gif" type="image/gif">
</head>
@extends('layoutt')

@section('title')
Регистрация
@stop

@section('content')

<div class="container">
<br /><br />
    @if ($errors->all())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <h1>Регистрация</h1>
{{ Form::open(array('route'=>'ye', 'method'=>'post', 'class' => 'form-horizontal')) }}
    <div class="form-group">
        {{ Form::label('email', 'E-Mail', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-5">
            {{ Form::email('email', null, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('username', 'Логин', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-5">
            {{ Form::text('username', null, array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('password', 'Пароль', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-5">
            {{ Form::password('password', array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        {{ Form::label('password_confirmation', 'Повтор пароля', array('class' => 'col-sm-2 control-label')) }}
        <div class="col-sm-5">
            {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-2">&nbsp;</div>
        <div class="col-sm-5">
            <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
        </div>
    </div>

{{ Form::close() }}
</div>
@stop
