@extends('layoutadmin')

@section('content')

{{Form::open(array('url'=>action('UsersController@clientRecord'), 'role'=>'record', 'method'=>'post',  'class' => 'form-horizontal registrationForm jquerymask')) }}

<div class="kit"></div>

@if (!$errors->isEmpty())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="form-group">
    <label class="col-sm-2 control-label"> Мэнеджер </label>

    <div class="col-sm-5">
        {{ Form::select('city', array('default' => 'Please Select')
        +User::where('admin','=','0')->where('manager','=','1')->lists('username', 'id'), null, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Имя </label>

    <div class="col-sm-5">
        {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Имя')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Фамилия </label>

    <div class="col-sm-5">
        {{ Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => 'Фамилия')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Отчество </label>

    <div class="col-sm-5">
        {{ Form::text('last_name',null, array('class' => 'form-control', 'placeholder' => 'Отчество')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Эмейл </label>

    <div class="col-sm-5">
        {{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Эмейл')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Телефон </label>

    <div class="col-sm-5">
        {{ Form::text('mobile',null, array('class' => 'form-control mobile', 'placeholder' => 'Мобильный')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>

    <div class="col-sm-5">
        {{ Form::submit('Отправить', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    </div>
</div>


{{Form::close()}}

@stop