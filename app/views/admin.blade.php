@extends('layoutadminka')

@section('title')
Вход
@stop

@section('headExtra')
    {{ HTML::style('css/signin.css') }}
@stop

@section('content')
<div class="kit"></div>
<div class="form-group">
    @if (Session::has('alert'))
    <div class="alert alert-danger">
        <p>{{ Session::get('alert') }}
    </div>
    @endif


    @if(Session::has('message'))
    <div class="jumbotron" align="center">
        <p>
            {{Session::get('message')}}
        </p>
    </div>
    @endif


    @if(!Auth::check())

    {{ Form::open(array('url' => action('UsersController@postLogin'), 'method' => 'post', 'role' => 'my', 'class' =>
    'form-horizontal')) }}
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>

        <div class="col-sm-3">
            {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Имя')) }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>

        <div class="col-sm-3">
            {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Пароль')) }}
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label swap checkbox"></label>

        <div class="col-sm-3">
            {{ Form::checkbox('remember-me', 1) }} Запомнить!
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>

        <div class="col-sm-3">
            {{ Form::submit('Вход', array('class' => 'btn btn-lg btn-primary btn-block')) }}
        </div>
    </div>
    {{Form::close()}}

    @endif

@stop
