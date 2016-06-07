@extends('layoutadmin')

@section('title')

@stop

@section('content')

<div class="kit"></div>

<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-8">
                    <form role="searchorder" name="uni" action="{{ action('OrdersController@orders') }}" method="get"
                          class="form-search" id="orders_search">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="input-group input-group-sm">
                            <input type="text" id="email" class="form-control" placeholder="Имя" name="email" required
                                   value="{{ $term }}"/>
                             <span class="input-group-addon"><a href="#" onclick="$('#orders_search').submit();">
                                     <i class="glyphicon glyphicon-search"></i></a>
                             </span>
                        </div>
                    </form>


                </div>
                <div class="col-lg-2">
                    <a class="btn btn-success btn-sm pull-right" href="{{ action('OrdersController@newOrderCreate') }}"><i
                            class="glyphicon glyphicon-plus"></i></a>

                </div>

                <ul class="nav nav-pills">
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Сортировка<b class="caret"></b></a>
                        <ul id="menu1" class="dropdown-menu">
                            <li><a href="{{action('OrdersController@orders') }}?id=old">Старые данные</a></li>
                            <li><a href="{{ action('OrdersController@orders') }}?id=new">Новые данные</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    @if(Session::has('newOrder'))
    <script type="text/javascript">
        $.growl.notice({message: "Новый заказ успешно занесен в базу данных..." });
    </script>
    @endif

    @if(Session::has('changeOrder'))
    <script type="text/javascript">
        $.growl.notice({message: "Данные заказа успешно изменены" });
    </script>
    @endif

    <div class="row">
        <table id="example" class="table table-striped table-bordered orderTable" class="tablesorter" data-height="400"
               data-side-pagination="server" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
               width="100%" cellspacing="0">

            <thead>
            <tr>
                <th class="sortable"> Эмейл <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Услуга <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Процесс <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Цена <i class="glyphicon pull-right"></i></th>
                <th class="sortable"> Дата <i class="glyphicon pull-right"></i></th>
                <th></th>
            </tr>
            </thead>

            <tfoot>
            <tr>
                <th>Эмейл</th>
                <th>Услуга</th>
                <th>Процесс</th>
                <th>Цена</th>
                <th>Дата</th>
                <th></th>
            </tr>
            </tfoot>

            <tbody>
            @foreach($ords as $ord)
            <tr>
                @foreach($ok as $all)
                @if(($all->id)==($ord->id))
                {{ ""; $for_id = $all->old }}
                <td id="{{$for_id}}">{{{$ord->getcostumer()->first()->email}}}</td>
                <td id="{{$for_id}}">{{{$ord->getservice()->first()->name}}}</td>
                <td id="{{$for_id}}">{{{$ord->process}}}</td>
                <td id="{{$for_id}}">{{{$ord->price}}}</td>
                <td id="{{$for_id}}">{{{$ord->created_at}}}</td>
                @endif
                @endforeach
                <td id="{{@$for_id}}">
                    <a href="#modal" class="btn btn-info btn-sm" data-toggle="modal"
                       data-target="#basicModal{{$ord->id}}"><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="#" onclick="return confirma({{$ord->id}});" id="ddd{{$ord->id}}"
                       class="btn btn-danger btn-sm "><i class="glyphicon glyphicon-remove-sign"></i></a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div style="position:relative">
        <div id="pager" class="pager" style="top: 30px; position: absolute; ">
            <form>
                <img src="/public/script/tablesorter-master/addons/pager/icons/first.png" class="first">
                <img src="/public/script/tablesorter-master/addons/pager/icons/prev.png" class="prev">
                <input type="text" class="pagedisplay">
                <img src="/public/script/tablesorter-master/addons/pager/icons/next.png" class="next">
                <img src="/public/script/tablesorter-master/addons/pager/icons/last.png" class="last">
                <select class="pagesize">
                    <option selected="selected" value="10">10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                    <option value="40">40</option>
                </select>
            </form>
        </div>
    </div>
</div>



@foreach($ords as $ord)
<div class="modal" id="basicModal{{ $ord->id }}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"><button class="close" type="button" data-dismiss="modal">x</button>
                <h4 class="modal-title" id="myModalLabel"><p>Услуга - {{{$ord->getservice()->first()->name}}} </p></h4>
            </div>
            <div class="modal-body">
                <h3>
                    <p>Эмейл:  {{{$ord->getcostumer()->first()->email}}} </p>
                    <p>Стоимость:  {{{$ord->price}}} </p>
                    <p>Комментарий:  {{{$ord->comment}}} </p>
                </h3>
            </div>
            <div class="modal-footer">
                <form action="{{ action('OrdersController@orderChange') }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="{{$ord->id}}" required />
                    <button type="submit" class="btn btn-info btn-sm">Изменить</button>
                    <a class="btn" href="#" data-dismiss="modal">Отмена</a>
                </form>
            </div>
        </div>

    </div>
</div>
@endforeach

<div class="confirm" id="non" ><p class="mydel" align="center">Удалить?</p>
    <p class="button-group" align="center">Я предупреждаю тебя!</p>
    <form action="{{action('OrdersController@orderDestroy') }}" method="get">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id" value=""/>
        <p align="center"><button class="yes btn btn-small btn-danger">Да</button>
            <button class="no btn btn-small">Нет</button></p>
    </form>
</div>

@stop
