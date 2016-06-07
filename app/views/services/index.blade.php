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


{{ Form::open(array('url' => action('ServicesController@store'), 'method' => 'post', 'role' => 'newserv', 'class' => 'form-horizontal')) }}
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-2">
    {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Service')) }}
        </div>
    </div>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-2">
    {{ Form::submit('Enter', array('class' => 'btn btn-lg btn-primary btn-block')) }}
    </div> </div>
{{Form::close()}}

@stop

