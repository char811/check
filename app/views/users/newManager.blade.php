@extends('layoutadmin')

@section('content')

{{Form::open(array('url'=>action('UsersController@managerRecord'), 'role'=>'manager', 'method'=>'post',  'class' => 'form-horizontal registrationForm')) }}

<div class="kit"></div>

@if (!$errors->isEmpty())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="form-group">
    <label class="col-sm-2 control-label"> Логин </label>

    <div class="col-sm-3">
        {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Логин')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Эмейл </label>

    <div class="col-sm-3">
        {{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Эмейл')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Пароль </label>

    <div class="col-sm-3">
        {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Пароль')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Повторите </label>

    <div class="col-sm-3">
        {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Пароль')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>

    <div class="col-sm-3">
        {{ Form::submit('Отправить', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    </div>
</div>

{{Form::close()}}

@stop