@extends('layoutadmin')

@section('content')
<div class="kit"></div>
@if (!$errors->isEmpty())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <p>{{ $error }}</p>
    @endforeach
</div>
@endif

@if(Session::has('message'))
<script type="text/javascript">
    $.growl.notice({message: "Данные успешно занесены в базу данных..." });
</script>
@endif


{{ Form::open(array('url' => action('CitiesController@store'), 'method' => 'post',  'class' => 'form-horizontal')) }}
<div class="form-group">
    <label class="col-sm-2 control-label">City</label>
    <div class="col-sm-2">
        {{ Form::text('engname', null, array('class' => 'form-control', 'placeholder' => 'City')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Город</label>
    <div class="col-sm-2">
        {{ Form::text('rusname', null, array('class' => 'form-control', 'placeholder' => 'Город')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Мэнеджер </label>

    <div class="col-sm-2">
        {{ Form::select('city', array('default' => 'Please Select')
        +User::where('admin','=','0')->where('manager','=','1')->lists('username', 'id'), null, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-2">
        {{ Form::submit('Enter', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    </div> </div>
{{Form::close()}}

@stop

