@extends('layoutadmin')

@section('content')

<div class="kit"></div>

@if(Session::has('message'))
<script type="text/javascript">
    $.growl.error({message: "Ошибка сохранения !" });
</script>
@endif


{{Form::model($model, array('route'=>array('users/index', $model->id),'class' => 'form-horizontal')) }}
<div class="form-group">
    <label class="col-sm-2 control-label"> Город </label>

    <div class="col-sm-5">
        {{ Form::select('city', City::all()->lists('engname', 'id'), null, array('class' => 'form-control')) }}
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label"> Имя </label>

    <div class="col-sm-5">
        {{ Form::text('username', null, array('class' => 'form-control', 'placeholder' => 'Имя'))}}
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
        {{ Form::text('mobile',null, array('class' => 'form-control', 'placeholder' => 'Мобильный')) }}
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