@extends('layoutadmin')

@section('content')

{{Form::open(array('url'=>action('OrdersController@orderRecord'), 'role'=>'recorder', 'method'=>'post',  'class' => 'form-horizontal registrationForm jquerymask')) }}

<div class="kit"></div>

@if (!$errors->isEmpty())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

<div class="form-group">
    <label class="col-sm-2 control-label"> Услуга </label>

    <div class="col-sm-5">
        {{ Form::select('service', array('default' => 'Please Select')
        +Service::all()->lists('name', 'id'), null, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Статус </label>

    <div class="col-sm-5">
        {{ Form::select('process', array('default' => 'Please Select')
        +Order::$statmessage, null, array('class' => 'form-control')) }}
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
        {{ Form::text('mobile',null, array('class' => 'form-control mobile', 'placeholder' => '0(000)-000-00-00')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Цена </label>

    <div class="col-sm-5">
        {{ Form::text('price', null, array('class' => 'form-control', 'placeholder' => 'Цена')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Сообщение </label>

    <div class="col-sm-5">
        {{ Form::textarea('comment', null, array('class' => 'form-control bbeditor')) }}<br/>
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