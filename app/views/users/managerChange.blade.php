@extends('layoutadmin')

@section('content')

<div class="kit"></div>

@if(Session::has('message'))
<script type="text/javascript">
    $.growl.error({message: "Ошибка сохранения !" });
</script>
@endif


{{Form::model($modelManager, array('route'=>array('users/showManagers', $modelManager->id),'class' => 'form-horizontal')) }}
<div class="form-group">
    <label class="col-sm-2 control-label"> Город </label>

    <div class="col-sm-3">
        {{ Form::select('city', City::all()->lists('engname', 'id'), null, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Имя </label>

    <div class="col-sm-3">
        {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Имя'))}}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Эмейл </label>

    <div class="col-sm-3">
        {{ Form::email('email', null, array('class' => 'form-control', 'placeholder' => 'Эмейл'))}}
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